<?php

namespace App\Tests\unit;

use App\Domain\Atm\Atm;
use App\Domain\Management\HeadOffice;
use App\Domain\SharedKernel\Money;
use App\Domain\SnackMachine\SnackMachine;
use PHPUnit\Framework\TestCase;

class HeadOfficeTest extends TestCase
{
    public function test_transfer_cash_from_snack_machine_to_atm(): void
    {
        $headOffice   = new HeadOffice();
        $snackMachine = new SnackMachine();
        $snackMachine->loadMoney(Money::Dollar());
        $atm = new Atm();

        $headOffice->unloadCashFromSnackMachine($snackMachine);
        $headOffice->loadCashToAtm($atm);


        $this->assertEquals(0, $headOffice->getCash()->getAmount());
        $this->assertEquals(0, $snackMachine->getMoneyInside()->getAmount());
        $this->assertEquals(1, $atm->getMoneyInside()->getAmount());
    }
}
