<?php


namespace App\Domain\Atm;


use App\Domain\Common\DomainEvent;

class BalanceChangedEvent implements DomainEvent
{
    private $delta;

    public function __construct(float $delta)
    {
        $this->delta = $delta;
    }

    public function getDelta(): float
    {
        return $this->delta;
    }
}