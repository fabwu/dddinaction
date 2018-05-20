<?php

namespace App\Domain;


use PHPUnit\Framework\TestCase;

class SnackPileTest extends TestCase
{
    public function test_negative_quantity_throws_exception()
    {
        $this->expectException(InvalidOperationException::class);
        new SnackPile(0, -1, 0);
    }

    public function test_negative_price_throws_exception()
    {
        $this->expectException(InvalidOperationException::class);
        new SnackPile(0, 0, -1);
    }
}
