<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
#[AsController]
class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function show(\Throwable $exception): Response
    {
         if ($exception instanceof NotFoundHttpException){        
             return $this->render('error/index.html.twig', [
                 'message' => $exception,
             ]);
         }
         
        return $this->render('error/index.html.twig', [
            'message' => ['statuscode'=> 500, 'message'=> 'NO Error!'],
        ]);
    }
}
