<?php


namespace App\Domain\Common;


class Utility
{
    public static function moneyToString($amount): string
    {
        if ($amount < 1) {
            return '¢ ' . $amount * 100;
        }

        return '$ ' . sprintf('%01.2f', $amount);
    }
}