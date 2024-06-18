<?php

namespace App\Services;

use App\Controller\MessagesController;
use App\Repository\TrabajadoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Trabajadores;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TrabajadoresService extends AbstractController
{
    private TrabajadoresRepository $trabajadoresRepository;

    private MessagesController $messagesController;

    public function __construct(
        TrabajadoresRepository $trabajadoresRepository,
        MessagesController $messagesController

    ) {
        $this->trabajadoresRepository = $trabajadoresRepository;
        $this->messagesController = $messagesController;
    }

    public function page(): array
    {
        return $this->trabajadoresRepository->pageall();
    }

    public function creartrabajador(Request $request): JsonResponse
    {


        $numCedula = $request->request->get('cedula');
        $cargo = $request->request->get('cargo');
        $nombre = $request->request->get('nombre');
        $celular = $request->request->get('celular');

        if (!$numCedula || !$cargo || !$nombre || !$celular) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertCampoVacio()], 200, ['Content-Type' => 'application/json']);
        }

        $trabajador = $this->trabajadoresRepository->findOneBy(['cedula' => $numCedula]);

        $json = null;
        if (!$trabajador instanceof Trabajadores) {
            $trabajador = new Trabajadores();
            $json = ['mensaje' => $this->messagesController->getSweetAlertTrabajadorCreado()];
        } else {
            $json = ['mensaje' => $this->messagesController->getSweetAlertTrabajadorActualizado()];
        };

        $trabajador->setNombre($nombre);
        $trabajador->setCargo($cargo);
        $trabajador->setCedula($numCedula);
        $trabajador->setCelular($celular);
        $this->trabajadoresRepository->guardar($trabajador);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }
    
    public function borrartrabajador(Request $request): JsonResponse
    {

        $id = $request->request->get('id');
        $trabajador = $this->trabajadoresRepository->findOneBy(['id' => $id]);

       
        if ($trabajador instanceof Trabajadores) {
            $this->trabajadoresRepository->borrar($trabajador);
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertTrabajadorEliminado()], 200, ['Content-Type' => 'application/json']);
            
        } 
        return  new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertError()], 200, ['Content-Type' => 'application/json']);
    }
}
