<?php

namespace App\Controller\admin;

use App\Services\admin\TrabajadoresService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/trabajadores/', name: 'app_trabajadores_')]
class TrabajadoresController extends AbstractController
{
    #[Route('index', name: 'index')]
    public function index(): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('admin/trabajadores.html.twig', );
    }

    #[Route('pagination', name: 'pagination')]
    public function pagination(
        TrabajadoresService $trabajadoresService
    ): JsonResponse {
        $json['rows'] = $trabajadoresService->page();
        $json['total'] = 800;
        $json['totalNotFiltered'] = 800;

        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('agregar', name: 'agregar')]
    public function agregar(
        TrabajadoresService $trabajadoresService,
        Request $request
    ): JsonResponse {
        return $trabajadoresService->creartrabajador($request);
    }

    #[Route('borrar', name: 'borrar')]
    public function borrar(
        TrabajadoresService $trabajadoresService,
        Request $request
    ): JsonResponse {
        return $trabajadoresService->borrartrabajador($request);
    }
}
