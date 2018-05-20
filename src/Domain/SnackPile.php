<?php


namespace App\Domain;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class SnackPile extends ValueObject
{
    /** @ORM\Column(type="integer") */
    private $snackId;

    /** @ORM\Column(type="integer") */
    private $quantity;

    /** @ORM\Column(type="float") */
    private $price;

    public function __construct(int $snackId, int $quantity, float $price)
    {
        if ($quantity < 0) {
            throw new InvalidOperationException('Quantity should be greater than zero');
        }

        if ($price < 0) {
            throw new InvalidOperationException('Price should be greater than zero');
        }

        $this->snackId  = $snackId;
        $this->quantity = $quantity;
        $this->price    = $price;
    }

    public function subtractOne(): SnackPile
    {
        return new SnackPile($this->snackId, $this->quantity - 1, $this->price);
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
            $this->snackId === $obj->snackId &&
            $this->quantity === $obj->quantity &&
            $this->price === $obj->price;
    }
}