<?php

namespace App\Controller;

use App\Entity\Trabajadores;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Trasacciones;
use App\Repository\TrasaccionesRepository;
use App\Repository\TrabajadoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route('/pruebas', name: 'app_pruebas')]
    public function prueb(EntityManagerInterface $entityManager, TrasaccionesRepository $trasaccionesRepository, TrabajadoresRepository $trabajadoresRepository): JsonResponse
    {
   
         $trasaccion = $trasaccionesRepository->find(0);
         if ($trasaccion instanceof Trasacciones) {
             $trasaccion->setEstado(1);
             $entityManager->persist($trasaccion);
             $entityManager->flush();
             
         } else {
             $trabajadores = $trabajadoresRepository->find(1);
             if ($trabajadores instanceof Trabajadores) {
                 $trasaccion = new Trasacciones();
                 $trasaccion->setEstado(0);
                 $trasaccion->setTrabajadores($trabajadores);
                 $entityManager->persist($trasaccion);
                 $entityManager->flush();
                 dd(1);
             }
         }
        return  new JsonResponse([], 200, ['Content-Type' => 'application/json']);
    }

    #[Route('/test', name: 'app_test')]
    public function test(EntityManagerInterface $entityManager, TrasaccionesRepository $trasaccionesRepository, TrabajadoresRepository $trabajadoresRepository): JsonResponse
    
    {
        return $this->render('error/index.html.twig');
    }

    #[Route('/test2', name: 'app_test2')]
    public function test2(EntityManagerInterface $entityManager, TrasaccionesRepository $trasaccionesRepository,TrabajadoresRepository $trabajadoresRepository): JsonResponse

    {
        return new JsonResponse([], 200, ['Content-Type' => 'application/json']);
    }
}


