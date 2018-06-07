<?php

namespace App\Domain;


use App\Domain\Common\InvalidOperationException;
use App\Domain\SnackMachine\Snack;
use App\Domain\SnackMachine\SnackPile;
use PHPUnit\Framework\TestCase;

class SnackPileTest extends TestCase
{
    public function test_negative_quantity_throws_exception()
    {
        $this->expectException(InvalidOperationException::class);
        new SnackPile(Snack::Chocolate(), -1, 0);
    }

    public function test_negative_price_throws_exception()
    {
        $this->expectException(InvalidOperationException::class);
        new SnackPile(Snack::Chocolate(), 0, -1);
    }
}
