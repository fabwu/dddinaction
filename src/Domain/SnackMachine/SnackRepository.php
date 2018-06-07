<?php


namespace App\Domain\SnackMachine;


interface SnackRepository
{
    public function find(int $id): Snack;
}
