<?php


namespace App\UI;


use App\Domain\Atm\AtmRepository;
use App\Domain\Management\HeadOfficeRepository;
use App\Domain\SnackMachine\SnackMachineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/office")
 */
class HeadOfficeController extends Controller
{
    private $headOfficeRepository;
    private $snackMachineRepository;
    private $atmRepository;

    public function __construct(
        HeadOfficeRepository $headOfficeRepository,
        SnackMachineRepository $snackMachineRepository,
        AtmRepository $atmRepository
    ) {
        $this->headOfficeRepository   = $headOfficeRepository;
        $this->snackMachineRepository = $snackMachineRepository;
        $this->atmRepository          = $atmRepository;
    }

    /**
     * @Route("/", name="head-office-overview")
     */
    public function overview(): Response
    {
        return $this->render('head-office.html.twig', [
            'headOffice'    => $this->headOfficeRepository->instance(),
            'snackMachines' => $this->snackMachineRepository->findAll(),
            'atms'          => $this->atmRepository->findAll(),
        ]);
    }

    /**
     * @Route("/unload-cash/{id}", name="head-office-unload-cash")
     */
    public function unloadCash(int $id)
    {
        $headOffice   = $this->headOfficeRepository->instance();
        $snackMachine = $this->snackMachineRepository->find($id);

        $headOffice->unloadCashFromSnackMachine($snackMachine);

        $this->headOfficeRepository->save($headOffice);
        $this->snackMachineRepository->save($snackMachine);

        return $this->redirectToRoute('head-office-overview');
    }

    /**
     * @Route("/load-cash/{id}", name="head-office-load-cash")
     */
    public function loadCash(int $id)
    {
        $headOffice = $this->headOfficeRepository->instance();
        $atm        = $this->atmRepository->find($id);

        $headOffice->loadCashToAtm($atm);

        $this->headOfficeRepository->save($headOffice);
        $this->atmRepository->save($atm);

        return $this->redirectToRoute('head-office-overview');
    }
}