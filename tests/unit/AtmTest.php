<?php

namespace App\Domain\Atm;


use App\Domain\SharedKernel\Money;
use PHPUnit\Framework\TestCase;

class AtmTest extends TestCase
{
    public function test_take_money_exchange_money_with_commission(): void
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Dollar());

        $atm->takeMoney(1);

        $this->assertEquals(0, $atm->getMoneyInside()->getAmount());
        $this->assertEquals(1.01, $atm->getMoneyCharged());
    }

    public function test_commission_is_at_least_one_cent(): void
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Cent());

        $atm->takeMoney(0.01);

        $this->assertEquals(0.02, $atm->getMoneyCharged());
    }

    public function test_commission_is_rounded_up_to_next_cent(): void
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Dollar());
        $atm->loadMoney(Money::TenCent());

        $atm->takeMoney(1.1);

        $this->assertEquals(1.12, $atm->getMoneyCharged());
    }

    public function test_zero_amount(): void
    {
        $atm = new Atm();

        $this->expectExceptionMessage('Invalid amount');

        $atm->takeMoney(0);
    }

    public function test_not_enough_money(): void
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Dollar());

        $this->expectExceptionMessage('Not enough money');

        $atm->takeMoney(2);
    }

    public function test_not_enough_change(): void
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Dollar());

        $this->expectExceptionMessage('Not enough change');

        $atm->takeMoney(0.5);
    }
}
