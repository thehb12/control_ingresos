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

#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/change/password', name: 'change_password', methods: ['POST'])]
    public function change_password(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        MessagesController $messagesController
    ): JsonResponse {
        $password = $request->request->get('newpassword');  
        $newpassword = $request->request->get('renewpassword');
      $json = [];

        if ($password == "" || $newpassword == "") {
            $json = ['message' => $messagesController->space_in_blank()];
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }

        if ($password != $newpassword) {
            $json = ['message' => $messagesController->password_no_match()];
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
            $json = ['message' => $messagesController->password_change_completed()];
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }
}
