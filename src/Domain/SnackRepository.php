<?php


namespace App\Domain;


interface SnackRepository
{
    public function find(int $id): ?Snack;
}
