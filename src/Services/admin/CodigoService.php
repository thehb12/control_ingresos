<?php

namespace App\Services\admin;

use App\Controller\MessagesController;
use App\Entity\Codigo;
use App\Entity\User;
use App\Repository\CodigoRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CodigoService
{
    private CodigoRepository $codigoRepository;
    private UserRepository $userRepository;
    private MessagesController $messagesController;

    public function __construct(
        CodigoRepository $codigoRepository,
        UserRepository $userRepository,
        MessagesController $messagesController
    ) {
        $this->codigoRepository = $codigoRepository;
        $this->userRepository = $userRepository;
        $this->messagesController = $messagesController;
    }

    public function validateCodigo(Request $request): ?JsonResponse
    {
        $codigo = $request->request->get('codigo');
        if (empty($codigo)) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertCampoVacio()], 200, ['Content-Type' => 'application/json']);
        }

        $codigoEntity = $this->codigoRepository->findOneBy(['codigo' => $codigo]);
        if (!$codigoEntity instanceof Codigo) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertError()], 200, ['Content-Type' => 'application/json']);
        }

        return null;
    }

    public function validateUser(Request $request): ?JsonResponse
    {
        $username = $request->request->get('username');
        if (empty($username)) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertCampoVacio()], 200, ['Content-Type' => 'application/json']);
        }

        $user = $this->userRepository->findOneBy(['username' => $username]);
        if ($user instanceof User) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertError()], 200, ['Content-Type' => 'application/json']);
        }

        return null;
    }

    public function validatePassword(Request $request): ?JsonResponse
    {
        $password = $request->request->get('password');
        if (empty($password)) {
            return new JsonResponse(['mensaje' => $this->messagesController->getSweetAlertCampoVacio()], 200, ['Content-Type' => 'application/json']);
        }

        return null;
    }
}
