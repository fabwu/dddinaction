<?php


namespace App\UI;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/atm")
 */
class AtmController extends Controller
{
    /**
     * @Route("/", name="atm-overview")
     */
    public function overview(SessionInterface $session): Response
    {
        return $this->render('atm.html.twig');
    }
}