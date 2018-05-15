<?php


namespace App\Domain;

class Slot extends Entity
{
    private $position;
    private $snackPile;
    private $snackMachine;

    public function __construct(SnackMachine $snackMachine, int $position)
    {
        $this->snackMachine = $snackMachine;
        $this->position     = $position;
        $this->snackPile    = new SnackPile(null, 0, 0.0);
    }

    public function setSnackPile(SnackPile $snackPile): void
    {
        $this->snackPile = $snackPile;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getSnackPile(): SnackPile
    {
        return $this->snackPile;
    }
}