<?php


namespace App\Infrastructure\Repository;

use App\Domain\SnackMachine\SnackMachine;
use App\Domain\SnackMachine\SnackMachineDto;
use App\Domain\SnackMachine\SnackMachineRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSnackMachineRepository implements SnackMachineRepository
{
    private $repository;

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $this->entityManager->getRepository(SnackMachine::class);
    }

    public function find(int $id): SnackMachine
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        $snackMachines = $this->repository->findAll();

        return array_map(function (SnackMachine $snackMachine) {
            return new SnackMachineDto($snackMachine->getId(), $snackMachine->getMoneyInside()->getAmount());
        }, $snackMachines);
    }

    public function save(SnackMachine $snackMachine): void
    {
        $this->entityManager->persist($snackMachine);
        $this->entityManager->flush();
    }
}