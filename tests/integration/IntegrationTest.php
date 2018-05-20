<?php


namespace App\Tests\integration;

use App\Domain\Snack;
use App\Domain\SnackMachine;
use App\Kernel;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTest extends KernelTestCase
{
    public function test_db_connection(): void
    {
        $snackMachine = $this->entityManager
            ->getRepository(SnackMachine::class)
            ->find(1);

        $this->assertNotNull($snackMachine);
    }

    public function test_snack_reference_data(): void
    {
        $repository = $this->entityManager->getRepository(Snack::class);

        $chocolate = $repository->find(Snack::Chocolate()->getId());
        $soda      = $repository->find(Snack::Soda()->getId());
        $gum       = $repository->find(Snack::Gum()->getId());
        $none      = $repository->find(Snack::None()->getId());

        $this->assertEquals($chocolate->getName(), Snack::Chocolate()->getName());
        $this->assertEquals($soda->getName(), Snack::Soda()->getName());
        $this->assertEquals($gum->getName(), Snack::Gum()->getName());
        $this->assertNull($none);
    }

    public static $class = Kernel::class;

    /** @var EntityManager */
    private $entityManager;

    protected function setUp()
    {
        $kernel              = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}