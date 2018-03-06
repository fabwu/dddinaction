<?php


namespace App\UI;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnackMachineController
{
    /**
     * @Route("/")
     */
    public function overview(): Response
    {
        return new Response('<h1>Test</h1>');
    }
}