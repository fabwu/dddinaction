<?php


namespace App\Domain;


use LogicException;

class SnackMachine extends Entity
{
    /** @var Money */
    private $moneyInTransaction;
    /** @var Money */
    private $moneyInside;

    public function __construct()
    {
        $this->moneyInTransaction = Money::None();
        $this->moneyInside        = Money::None();
    }

    public function insertMoney(Money $money)
    {
        if (
            Money::Cent()->isNotEquals($money) &&
            Money::TenCent()->isNotEquals($money) &&
            Money::Quarter()->isNotEquals($money) &&
            Money::Dollar()->isNotEquals($money) &&
            Money::FiveDollar()->isNotEquals($money) &&
            Money::TwentyDollar()->isNotEquals($money)
        ) {
            throw new LogicException('You can only insert one coin at a time');
        }

        $this->moneyInTransaction = $this->moneyInTransaction->add($money);
    }

    public function returnMoney()
    {
        $this->moneyInTransaction = Money::None();
    }

    public function buySnack()
    {
        $this->moneyInside        = $this->moneyInside->add($this->moneyInTransaction);
        $this->moneyInTransaction = Money::None();
    }

    public function getMoneyInTransaction(): Money
    {
        return $this->moneyInTransaction;
    }

    public function getMoneyInside(): Money
    {
        return $this->moneyInside;
    }
}