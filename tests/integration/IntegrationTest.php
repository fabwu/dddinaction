<?php


namespace App\Tests\integration;

use App\Domain\SnackMachine;
use App\Kernel;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTest extends KernelTestCase
{
    static $class = Kernel::class;
    /** @var EntityManager */
    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
                                      ->get('doctrine')
                                      ->getManager();
    }

    public function testDbConnection()
    {
        $snackMachine = $this->entityManager
            ->getRepository(SnackMachine::class)
            ->find(1);

        $this->assertNotNull($snackMachine);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}