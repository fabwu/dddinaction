<?php

namespace App\Tests\unit;

use App\Domain\Management\HeadOffice;
use App\Domain\SharedKernel\Money;
use App\Domain\SnackMachine\SnackMachine;
use PHPUnit\Framework\TestCase;

class HeadOfficeTest extends TestCase
{
    public function test_unload_cash_from_snack_machine(): void
    {
        $headOffice   = new HeadOffice();
        $snackMachine = new SnackMachine();
        $snackMachine->loadMoney(Money::Dollar());

        $headOffice->unloadCashFromSnackMachine($snackMachine);

        $this->assertEquals(1, $headOffice->getCash()->getAmount());
    }
}
