<?php

namespace App\Services;

use App\Controller\MessagesController;
use App\Entity\Trasacciones;
use App\Entity\Trabajadores;
use App\Repository\TrasaccionesRepository;
use App\Repository\TrabajadoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TrasaccionesService extends AbstractController
{
    private TrasaccionesRepository $trasaccionesRepository;
    private TrabajadoresRepository $trabajadoresRepository;

    private MessagesController $messagesController;

    public function __construct(
        TrasaccionesRepository $trasaccionesRepository,
        MessagesController $messagesController,
        TrabajadoresRepository $trabajadoresRepository,

    ) {
        $this->trasaccionesRepository = $trasaccionesRepository;
        $this->trabajadoresRepository = $trabajadoresRepository;
        $this->messagesController = $messagesController;
    }
    public function page(): array
    {
        return $this->trasaccionesRepository->pageall();
    }
    public function creartrasaccion(Request $request): JsonResponse
    {
        $numCedula = $request->request->get('cedula');
        if (!$numCedula) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertCampoVacio()], 200, ['Content-Type' => 'application/json']);
        }

        $trabajador = $this->trabajadoresRepository->findOneBy(['cedula' => $numCedula]);
        if (!$trabajador instanceof Trabajadores) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertError('no existe trabajador')], 200, ['Content-Type' => 'application/json']);
        }

        $trasaccion = $this->trasaccionesRepository->findOneBy(['trabajadores' => $trabajador, 'estado' => 0]);

        $json = null;
        if (!$trasaccion instanceof Trasacciones) {
            $trasaccion = new Trasacciones();
            $trasaccion->setTrabajadores($trabajador);
            //$trasaccion->setFechaEntrada(/new DataTime());
            $trasaccion->setEstado(0);
            $json = ['mensaje' => $this->messagesController->getSweetAlertError('no existe transacion')];
        }else{
               //$trasaccion->setFechaSalida(/new DataTime());
               $trasaccion->setEstado(1);
            $json = ['mensaje' => $this->messagesController->getSweetAlertError('existe transacion')];
        }

        $this->trasaccionesRepository->guardar($trasaccion);
        
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    public function borrartrasaccion(Request $request): JsonResponse
    {

        $trabajador_id = $request->$request->get('trabajadores_id');
        $trasaccion = $this->trasaccionesRepository->findOneBy(['cedula' => $trabajador_id]);


        if ($trasaccion instanceof Trasacciones) {
            $this->trasaccionesRepository->borrar($trasaccion);
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertTrabajadorEliminado()], 200, ['Content-Type' => 'application/json']);
        }
        dd($trabajador_id);
        return  new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertError()], 200, ['Content-Type' => 'application/json']);
    }
}
