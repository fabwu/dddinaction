<?php


namespace App\Tests\integration;

use App\Domain\Snack;
use App\Domain\SnackMachineRepository;
use App\Domain\SnackRepository;
use App\Kernel;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTest extends KernelTestCase
{
    public function test_db_connection(): void
    {
        $snackMachine = $this->container
            ->get(SnackMachineRepository::class)
            ->find(1);

        $this->assertNotNull($snackMachine);
    }

    public function test_snack_reference_data(): void
    {
        $repository = $this->container->get(SnackRepository::class);
        $chocolate  = $repository->find(Snack::Chocolate()->getId());
        $soda       = $repository->find(Snack::Soda()->getId());
        $gum        = $repository->find(Snack::Gum()->getId());
        $none       = $repository->find(Snack::None()->getId());

        $this->assertEquals($chocolate->getName(), Snack::Chocolate()->getName());
        $this->assertEquals($soda->getName(), Snack::Soda()->getName());
        $this->assertEquals($gum->getName(), Snack::Gum()->getName());
        $this->assertNull($none);
    }

    public static $class = Kernel::class;

    /** @var ContainerInterface */
    private $container;

    protected function setUp()
    {
        $kernel          = self::bootKernel();
        $this->container = $kernel->getContainer();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }
}