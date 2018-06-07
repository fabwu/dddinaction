<?php


namespace App\UI;


use App\Domain\Atm\AtmRepository;
use App\Domain\Common\InvalidOperationException;
use App\Domain\Common\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/atm")
 */
class AtmController extends Controller
{
    private const ATM_ID = 1;

    private $atmRepository;

    public function __construct(AtmRepository $atmRepository)
    {
        $this->atmRepository = $atmRepository;
    }

    /**
     * @Route("/", name="atm-overview")
     */
    public function overview(): Response
    {
        return $this->render('atm.html.twig', [
            'atm' => $this->atmRepository->find(self::ATM_ID),
        ]);
    }

    /**
     * @Route("/take-money", name="atm-take-money")
     */
    public function takeMoney(Request $request): Response
    {
        $amount = $request->get('amount');
        $atm    = $this->atmRepository->find(self::ATM_ID);

        try {
            $atm->takeMoney((float)$amount);
            $this->atmRepository->save($atm);
            $msg = 'You have taken ' . Utility::moneyToString($amount);
        } catch (InvalidOperationException $e) {
            $msg = $e->getMessage();
        }

        $this->addFlash('info', $msg);

        return $this->redirectToRoute('atm-overview');
    }
}