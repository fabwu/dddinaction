<?php


namespace App\Domain\Atm;


use App\Domain\Common\AggregateRoot;
use App\Domain\Common\InvalidOperationException;
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
        $error = $this->canTakeMoney($amount);

        if ($error !== '') {
            throw new InvalidOperationException($error);
        }

        $output            = $this->moneyInside->allocate($amount);
        $this->moneyInside = $this->moneyInside->sub($output);

        $this->moneyCharged += $this->calculateAmountWithCommission($amount);
    }

    public function canTakeMoney(float $amount): string
    {
        if ($amount <= 0) {
            return 'Invalid amount';
        }

        if ($this->moneyInside->getAmount() < $amount) {
            return 'Not enough money';
        }

        if ( ! $this->moneyInside->allocate($amount)->getAmount()) {
            return 'Not enough change';
        }

        return '';
    }

    private function calculateAmountWithCommission(float $amount): float
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
}