<?php


namespace App\Domain\SnackMachine;


use App\Domain\Common\Utility;

class SnackMachineDto
{
    private $id;
    private $moneyInside;

    public function __construct(int $id, float $moneyInside)
    {
        $this->id          = $id;
        $this->moneyInside = $moneyInside;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMoneyInside(): string
    {
        return Utility::moneyToString($this->moneyInside);
    }
}