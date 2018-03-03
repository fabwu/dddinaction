<?php

namespace App\Domain;


use LogicException;
use PHPUnit\Framework\TestCase;

class SnackMachineTest extends TestCase
{
    public function testInsertedMoneyGoesToMoneyInTransaction()
    {
        $snackMachine = new SnackMachine();

        $snackMachine->insertMoney(Money::Cent());
        $snackMachine->insertMoney(Money::Dollar());

        $this->assertEquals(1.01, $snackMachine->getMoneyInTransaction()->getAmount());
    }

    public function testCannotInsertMoreThanOneCoinOrNoteAtATime()
    {
        $snackMachine = new SnackMachine();
        $twoCent      = Money::Cent()->add(Money::Cent());

        $this->expectException(LogicException::class);

        $snackMachine->insertMoney($twoCent);
    }

    public function test_return_money_empties_money_in_transaction()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->insertMoney(Money::Cent());

        $snackMachine->returnMoney();

        $this->assertEquals(0, $snackMachine->getMoneyInTransaction()->getAmount());
    }

    public function test_money_in_transaction_goes_to_money_inside_after_purchase()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->insertMoney(Money::Dollar());
        $snackMachine->insertMoney(Money::Dollar());

        $snackMachine->buySnack();

        $this->assertEquals(Money::None(), $snackMachine->getMoneyInTransaction());
        $this->assertEquals(0, $snackMachine->getMoneyInside()->getAmount());
    }
}
