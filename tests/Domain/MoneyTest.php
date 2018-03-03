<?php

namespace App\Tests\Domain;


use App\Domain\Money;
use LogicException;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testTwoMoneyWithSameAmountAreEqual()
    {
        $money1 = new Money(1, 2, 3, 4, 5, 6);
        $money2 = new Money(1, 2, 3, 4, 5, 6);

        $isEquals = $money1->isEquals($money2);

        $this->assertTrue($isEquals);
    }

    public function testTwoMoneyWithDifferentAmountAreNotEqual()
    {
        $money1 = new Money(1, 2, 3, 4, 5, 6);
        $money2 = new Money(1, 2, 100, 4, 5, 6);

        $isEquals = $money1->isEquals($money2);

        $this->assertFalse($isEquals);
    }

    public function testSumOfTwoMoneyReturnNewMoney()
    {
        $money1 = new Money(1, 2, 3, 4, 5, 6);
        $money2 = new Money(1, 2, 3, 4, 5, 6);

        $sum = $money1->add($money2);

        $this->assertEquals(2, $sum->getOneCentCount());
        $this->assertEquals(4, $sum->getTenCentCount());
        $this->assertEquals(6, $sum->getQuarterCount());
        $this->assertEquals(8, $sum->getOneDollarCount());
        $this->assertEquals(10, $sum->getFiveDollarCount());
        $this->assertEquals(12, $sum->getTwentyDollarCount());
    }

    public function testSubstractionOfTwoMoneysProducesCorrectResult()
    {
        $money1 = new Money(10, 10, 10, 10, 10, 10);
        $money2 = new Money(1, 2, 3, 4, 5, 6);

        $result = $money1->sub($money2);

        $this->assertEquals(9, $result->getOneCentCount());
        $this->assertEquals(8, $result->getTenCentCount());
        $this->assertEquals(7, $result->getQuarterCount());
        $this->assertEquals(6, $result->getOneDollarCount());
        $this->assertEquals(5, $result->getFiveDollarCount());
        $this->assertEquals(4, $result->getTwentyDollarCount());
    }

    public function testShouldNotSubstractMoreThanExists()
    {
        $money1 = new Money(0, 1, 0, 0, 0, 0);
        $money2 = new Money(1, 0, 0, 0, 0, 0);

        $this->expectException(LogicException::class);

        $money1->sub($money2);
    }

    /**
     * @dataProvider amountProvider
     */
    public function testAmountCalculatedCorrectly($a, $b, $c, $d, $e, $f, $amount)
    {
        $money = new Money($a, $b, $c, $d, $e, $f);

        $this->assertEquals($amount, $money->getAmount());
    }

    public function amountProvider()
    {
        return [
            [0, 0, 0, 0, 0, 0, 0],
            [1, 0, 0, 0, 0, 0, 0.01],
            [1, 2, 0, 0, 0, 0, 0.21],
            [1, 2, 3, 0, 0, 0, 0.96],
            [1, 2, 3, 4, 0, 0, 4.96],
            [1, 2, 3, 4, 5, 0, 29.96],
            [1, 2, 3, 4, 5, 6, 149.96],
            [11, 0, 0, 0, 0, 0, 0.11],
            [110, 0, 0, 0, 100, 0, 501.1],
        ];
    }

    /**
     * @dataProvider negativProvider
     */
    public function testCantCreateMoneyWithNegativeCount($a, $b, $c, $d, $e, $f)
    {
        $this->expectException(LogicException::class);

        new Money($a, $b, $c, $d, $e, $f);
    }

    public function negativProvider()
    {
        return [
            [-1, 0, 0, 0, 0, 0],
            [0, -1, 0, 0, 0, 0],
            [0, 0, -1, 0, 0, 0],
            [0, 0, 0, -1, 0, 0],
            [0, 0, 0, 0, -1, 0],
            [0, 0, 0, 0, 0, -1],
        ];
    }
}
