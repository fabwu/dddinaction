<?php


namespace App\Domain\Atm;


use App\Domain\Common\Utility;

class AtmDto
{
    private $id;
    private $cash;

    public function __construct(int $id, float $cash)
    {
        $this->id   = $id;
        $this->cash = $cash;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCash(): string
    {
        return Utility::moneyToString($this->cash);
    }
}