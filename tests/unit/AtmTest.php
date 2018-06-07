<?php

namespace App\Domain\Atm;


use App\Domain\SharedKernel\Money;
use PHPUnit\Framework\TestCase;

class AtmTest extends TestCase
{
    public function test_take_money_exchangey_money_with_commission(): void
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

    public function test_zero_amount()
    {
        $atm = new Atm();

        $error = $atm->canTakeMoney(0);

        $this->assertEquals('Invalid amount', $error);
    }

    public function test_not_enough_money()
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Dollar());

        $error = $atm->canTakeMoney(2);

        $this->assertEquals('Not enough money', $error);
    }

    public function test_not_enough_change()
    {
        $atm = new Atm();
        $atm->loadMoney(Money::Dollar());

        $error = $atm->canTakeMoney(0.5);

        $this->assertEquals('Not enough change', $error);
    }
}
