<?php


namespace App\Domain;


use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Snack extends AggregateRoot
{
    public static function None()
    {
        return new self(0, 'None');
    }

    public static function Chocolate()
    {
        return new self(1, 'Chocolate');
    }

    public static function Soda()
    {
        return new self(2, 'Soda');
    }

    public static function Gum()
    {
        return new self(3, 'Gum');
    }

    /** @ORM\Column(type="string") */
    private $name;

    private function __construct(int $id, string $name)
    {
        $this->name = $name;
        $this->id   = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}