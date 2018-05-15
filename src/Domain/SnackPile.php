<?php


namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class SnackPile extends ValueObject
{
    /** @ORM\ManyToOne(targetEntity="App\Domain\Snack") */
    private $snack;

    /** @ORM\Column(type="integer") */
    private $quantity;

    /** @ORM\Column(type="float") */
    private $price;

    public function __construct(Snack $snack = null, int $quantity, float $price)
    {
        if ($quantity < 0) {
            throw new InvalidOperationException('Quantity should be greater than zero');
        }

        if ($price < 0) {
            throw new InvalidOperationException('Price should be greater than zero');
        }

        $this->snack    = $snack;
        $this->quantity = $quantity;
        $this->price    = $price;
    }

    public function subtractOne(): SnackPile
    {
        return new SnackPile($this->snack, $this->quantity - 1, $this->price);
    }

    public function getSnack(): Snack
    {
        return $this->snack;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function isEquals($obj): bool
    {
        return
            $obj instanceof self &&
            $this->snack === $obj->snack &&
            $this->quantity === $obj->quantity &&
            $this->price === $obj->price;
    }
}