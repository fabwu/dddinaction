<?php


namespace App\Domain;

interface SnackMachineRepository
{
    public function find(int $id): ?SnackMachine;
}