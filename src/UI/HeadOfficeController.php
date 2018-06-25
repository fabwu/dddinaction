<?php


namespace App\UI;


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

    public function __construct(HeadOfficeRepository $headOfficeRepository, SnackMachineRepository $snackMachineRepository)
    {
        $this->headOfficeRepository   = $headOfficeRepository;
        $this->snackMachineRepository = $snackMachineRepository;
    }

    /**
     * @Route("/", name="head-office-overview")
     */
    public function overview(): Response
    {
        return $this->render('head-office.html.twig', [
            'headOffice'    => $this->headOfficeRepository->instance(),
            'snackMachines' => $this->snackMachineRepository->findAll(),
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
}