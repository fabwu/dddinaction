<?php


namespace App\Database\Repository;

use App\Domain\Atm\Atm;
use App\Domain\Atm\AtmRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineAtmRepository implements AtmRepository
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Atm::class);
    }

    public function find(int $id): ?Atm
    {
        return $this->repository->find($id);
    }
}