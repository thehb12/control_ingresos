<?php

namespace App\Controller\config;

use App\Services\config\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->render('config/profile.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/change/password', name: 'change_password', methods: ['POST'])]
    public function change_password(
        Request $request,
        ProfileService $profileService
    ): JsonResponse {

        return $profileService->actualizarPassword($request, $this->getUser());
    }

    #[Route('/change/profile', name: 'change_profile', methods: ['POST'])]
    public function profile(
        Request $request,
        ProfileService $profileService

    ): JsonResponse {
        return $profileService->UpdateProfile($request, $this->getUser());
    }
}
