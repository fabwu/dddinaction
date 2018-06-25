<?php


namespace App\Domain\Management;


use App\Domain\Atm\Atm;
use App\Domain\Common\AggregateRoot;
use App\Domain\Common\Utility;
use App\Domain\SharedKernel\Money;
use App\Domain\SnackMachine\SnackMachine;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class HeadOffice extends AggregateRoot
{
    /** @ORM\Column(type="float") */
    private $balance;
    /** @ORM\Embedded(class="App\Domain\SharedKernel\Money") */
    private $cash;

    public function __construct()
    {
        $this->balance = 0.0;
        $this->cash    = Money::None();
    }

    public function changeBalance(float $delta): void
    {
        $this->balance += $delta;
    }

    public function unloadCashFromSnackMachine(SnackMachine $snackMachine): void
    {
        $money      = $snackMachine->unloadMoney();
        $this->cash = $this->cash->add($money);
    }

    public function loadCashToAtm(Atm $atm): void
    {
        $atm->loadMoney($this->cash);
        $this->cash = Money::None();
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getBalanceAsString(): string
    {
        return Utility::moneyToString($this->balance);
    }

    public function getCash(): Money
    {
        return $this->cash;
    }
}