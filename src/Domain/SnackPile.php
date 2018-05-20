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

    public static function Empty()
    {
        return new self(Snack::None(), 0, 0.0);
    }

    public function __construct(Snack $snack, int $quantity, float $price)
    {
        if ($quantity < 0) {
            throw new InvalidOperationException('Quantity should be greater than zero');
        }

        if ($price < 0) {
            throw new InvalidOperationException('Price should be greater than zero');
        }

        $this->snackId  = $snack->getId();
        $this->quantity = $quantity;
        $this->price    = $price;
    }

    public function subtractOne(): SnackPile
    {
        $oldSnackId            = $this->snackId;
        $newSnackPile          = new SnackPile(Snack::None(), $this->quantity - 1, $this->price);
        $newSnackPile->snackId = $oldSnackId;

        return $newSnackPile;
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