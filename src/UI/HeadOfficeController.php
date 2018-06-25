<?php


namespace App\UI;


use App\Domain\Atm\PaymentGateway;
use App\Domain\Management\HeadOfficeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/office")
 */
class HeadOfficeController extends Controller
{

    private $headOfficeRepository;

    public function __construct(HeadOfficeRepository $headOfficeRepository, PaymentGateway $paymentGateway)
    {
        $this->headOfficeRepository = $headOfficeRepository;
    }

    /**
     * @Route("/", name="head-office-overview")
     */
    public function overview(): Response
    {
        return $this->render('head-office.html.twig', [
            'headOffice' => $this->headOfficeRepository->instance(),
        ]);
    }
}