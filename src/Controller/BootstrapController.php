<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BootstrapController extends AbstractController
{
    #[Route('/table', name: 'app_tabla')]
    public function index(): Response
    {
        return $this->render('bootstrap/index.html.twig', [
            'controller_name' => 'BootstrapController',
        ]);
    }
}
