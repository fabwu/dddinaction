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

        $this->assertEquals(1.01, $snackMachine->getMoneyInTransaction());
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

        $this->assertEquals(0, $snackMachine->getMoneyInTransaction());
    }

    public function test_buy_snack_trades_inserted_money_for_a_snack()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->loadSnack(1, new SnackPile(0, 3, 1));
        $snackMachine->insertMoney(Money::Dollar());

        $snackMachine->buySnack(1);

        $this->assertEquals(0, $snackMachine->getMoneyInTransaction());
        $this->assertEquals(1, $snackMachine->getMoneyInside()->getAmount());

        $this->assertEquals(2, $snackMachine->getSnackPile(1)->getQuantity());
    }

    public function test_cannot_make_purchase_when_there_is_no_snack()
    {
        $this->expectException(InvalidOperationException::class);

        $snackMachine = new SnackMachine();
        $snackMachine->buySnack(1);
    }

    public function test_cannot_make_purchase_if_not_enough_money_inserted()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->loadSnack(1, new SnackPile(1, 1, 2));
        $snackMachine->insertMoney(Money::Dollar());

        $this->expectException(InvalidOperationException::class);

        $snackMachine->buySnack(1);
    }

    public function test_snack_machine_returns_money_with_highest_denomination_first()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->loadMoney(Money::Dollar());

        $snackMachine->insertMoney(Money::Quarter());
        $snackMachine->insertMoney(Money::Quarter());
        $snackMachine->insertMoney(Money::Quarter());
        $snackMachine->insertMoney(Money::Quarter());
        $returnedMoney = $snackMachine->returnMoney();

        $this->assertEquals(4, $snackMachine->getMoneyInside()->getQuarterCount());
        $this->assertEquals(0, $snackMachine->getMoneyInside()->getOneDollarCount());
        $this->assertEquals(1, $returnedMoney->getOneDollarCount());
    }

    public function test_after_purchase_change_is_returned()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->loadSnack(1, new SnackPile(1, 1, 0.5));
        $snackMachine->loadMoney(Money::TenCent()->multiply(10));


        $snackMachine->insertMoney(Money::Dollar());
        $snackMachine->buySnack(1);

        $this->assertEquals(1.5, $snackMachine->getMoneyInside()->getAmount());
        $this->assertEquals(0, $snackMachine->getMoneyInTransaction());
    }

    public function test_cannot_buy_snack_if_not_enough_change()
    {
        $snackMachine = new SnackMachine();
        $snackMachine->loadSnack(1, new SnackPile(1, 1, 0.5));
        $snackMachine->insertMoney(Money::Dollar());

        $this->expectException(InvalidOperationException::class);

        $snackMachine->buySnack(1);

    }
}
