<?php


namespace App\Database\Repository;

use App\Domain\Atm\Atm;
use App\Domain\Atm\AtmRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineAtmRepository implements AtmRepository
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $this->entityManager->getRepository(Atm::class);
    }

    public function find(int $id): Atm
    {
        return $this->repository->find($id);
    }

    public function save(Atm $atm): void
    {
        $this->entityManager->persist($atm);
        $this->entityManager->flush();
    }
}