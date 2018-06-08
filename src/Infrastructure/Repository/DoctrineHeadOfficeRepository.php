<?php


namespace App\Infrastructure\Repository;

use App\Domain\Management\HeadOffice;
use App\Domain\Management\HeadOfficeRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineHeadOfficeRepository implements HeadOfficeRepository
{
    private const HEAD_OFFICE_ID = 1;

    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $this->entityManager->getRepository(HeadOffice::class);
    }

    public function instance(): HeadOffice
    {
        return $this->repository->find(self::HEAD_OFFICE_ID);
    }

    public function save(HeadOffice $headOffice): void
    {
        $this->entityManager->persist($headOffice);
        $this->entityManager->flush();
    }
}