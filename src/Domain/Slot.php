<?php


namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Slot extends Entity
{
    /**
     * @ORM\Column(type="integer")
     */
    private $position;
    /**
     * @var SnackPile
     * @ORM\Embedded(class="App\Domain\SnackPile")
     */
    private $snackPile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\SnackMachine", inversedBy="slots")
     */
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