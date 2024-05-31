<?php

namespace App\Controller;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;

#[Route('/profile', name: 'app_profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/change/password', name: 'change_password', methods: ['PATCH'])]
    public function change_password(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher
    ): JsonResponse {
        $password = $request->request->get('password');  
        $newpassword = $request->request->get('newpassword');
        $json = ['password'=> $password,"newpassword"=> $newpassword];
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);

        if ($password == "" || $newpassword == "") {
            $json = ['message' => 'Uno o mas espacios estan en blanco'];
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }

        if ($password != $newpassword) {
            $json = ['message' => 'Las contraeñas no coinciden'];
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }

        if ($password === $newpassword) {
            $user = $userRepository->find($this->getUser());
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $newpassword
                )
            );
            $userRepository->Save($user);
            $json = ['message' => 'La contraseña cambio exitosamente'];
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }
}
