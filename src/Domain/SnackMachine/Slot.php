<?php


namespace App\Domain\SnackMachine;

use App\Domain\Common\Entity;
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
     * @ORM\Embedded(class="App\Domain\SnackMachine\SnackPile")
     */
    private $snackPile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\SnackMachine\SnackMachine", inversedBy="slots")
     */
    private $snackMachine;

    public function __construct(SnackMachine $snackMachine, int $position)
    {
        $this->snackMachine = $snackMachine;
        $this->position     = $position;
        $this->snackPile    = SnackPile::Empty();
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