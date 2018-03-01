<?php

namespace App\Tests\Domain;


use App\Domain\Money;
use LogicException;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
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
