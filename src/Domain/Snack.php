<?php


namespace App\Domain;


class Snack extends AggregateRoot
{
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