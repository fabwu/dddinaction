<?php


namespace App\Database\Repository;

use App\Domain\SnackMachine\SnackMachine;
use App\Domain\SnackMachine\SnackMachineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSnackMachineRepository implements SnackMachineRepository
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(SnackMachine::class);
    }

    public function find(int $id): ?SnackMachine
    {
        return $this->repository->find($id);
    }
}