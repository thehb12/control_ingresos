<?php

namespace App\Controller\procesos;

use App\Services\procesos\TrasaccionesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/trasacciones/', name: 'app_trasacciones_')]
class TrasaccionesController extends AbstractController
{
    #[Route('index', name: 'index')]
    public function index(): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('procesos/trasacciones.html.twig');
    }
    #[Route('pagination', name: 'pagination')]
    public function pagination(
        Request $request,
        TrasaccionesService $trasaccionesService
        ): JsonResponse 
    {
        $json['rows'] = $trasaccionesService->page($request);
         $json['total'] = $trasaccionesService->pagetotal();
         $json['totalNotFiltered'] = 800;
    
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']); 
    }
    #[Route('agregar', name: 'agregar')]
    public function agregar(
        TrasaccionesService $trasaccionesService,
        Request $request
        ): JsonResponse 
    {
       return $trasaccionesService->creartrasaccion($request);
    
        
    }

    #[Route('borrar', name: 'borrar')]
    public function borrar(
        TrasaccionesService $trasaccionesService,
        Request $request
        ): JsonResponse 
    {
       return $trasaccionesService->borrartrasaccion($request);
        
    }

}
