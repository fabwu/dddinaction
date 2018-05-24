<?php


namespace App\Database\Repository;

use App\Domain\Snack;
use App\Domain\SnackRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSnackRepository implements SnackRepository
{
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Snack::class);
    }

    public function find(int $id): ?Snack
    {
        return $this->repository->find($id);
    }
}