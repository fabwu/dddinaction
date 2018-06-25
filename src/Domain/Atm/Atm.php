<?php


namespace App\Domain\Atm;


use App\Domain\Common\AggregateRoot;
use App\Domain\Common\InvalidOperationException;
use App\Domain\Common\Utility;
use App\Domain\SharedKernel\Money;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Atm extends AggregateRoot
{
    /**
     * @var Money
     * @ORM\Embedded(class="App\Domain\SharedKernel\Money")
     */
    private $moneyInside;

    /** @ORM\Column(type="float") */
    private $moneyCharged;

    private const COMMISSION_RATE = 0.01;

    public function __construct()
    {
        $this->moneyInside  = Money::None();
        $this->moneyCharged = 0;
    }

    public function takeMoney(float $amount): void
    {
        $this->canTakeMoney($amount);

        $output            = $this->moneyInside->allocate($amount);
        $this->moneyInside = $this->moneyInside->sub($output);

        $amountWithCommission = $this->calculateAmountWithCommission($amount);
        $this->moneyCharged   += $amountWithCommission;

        $this->raise(new BalanceChangedEvent($amountWithCommission));
    }

    private function canTakeMoney(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidOperationException('Invalid amount');
        }

        if ($this->moneyInside->getAmount() < $amount) {
            throw new InvalidOperationException('Not enough money');
        }

        if ( ! $this->moneyInside->allocate($amount)->getAmount()) {
            throw new InvalidOperationException('Not enough change');
        }
    }

    public function calculateAmountWithCommission(float $amount): float
    {
        $commission   = $amount * self::COMMISSION_RATE;
        $lessThanCent = fmod($commission, 0.01);
        if ($lessThanCent > 0) {
            $commission = $commission - $lessThanCent + 0.01;
        }

        return $amount + $commission;
    }

    public function loadMoney(Money $money): void
    {
        $this->moneyInside = $this->moneyInside->add($money);
    }

    public function getMoneyInside(): Money
    {
        return $this->moneyInside;
    }

    public function getMoneyCharged(): float
    {
        return $this->moneyCharged;
    }

    public function getMoneyChargedAsString(): string
    {
        return Utility::moneyToString($this->moneyCharged);
    }
}