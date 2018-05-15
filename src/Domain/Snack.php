<?php


namespace App\Domain;


use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Snack extends AggregateRoot
{
    /** @ORM\Column(type="string") */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function Snickers(): Snack
    {
        return new self('Snickers');
    }

    public function getName(): string
    {
        return $this->name;
    }
}