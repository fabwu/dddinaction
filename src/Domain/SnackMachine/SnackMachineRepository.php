<?php


namespace App\Domain\SnackMachine;

interface SnackMachineRepository
{
    public function find(int $id): SnackMachine;

    public function save(SnackMachine $snackMachine): void;
}