<?php


namespace App\Domain;


abstract class ValueObject
{
    abstract public function isEquals($obj): bool;

    public function isNotEquals($obj): bool
    {
        return ! $this->isEquals($obj);
    }
}