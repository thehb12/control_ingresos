<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\admin\CodigoService;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, CodigoService $codigoService, Security $security, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $codigo = $request->request->get('codigo');

            // Validar el código
            $codigoValidationResponse = $codigoService->validateCodigo($request);
            if ($codigoValidationResponse !== null) {
                return $codigoValidationResponse;
            }

            // Validar el usuario
            $userValidationResponse = $codigoService->validateUser($request);
            if ($userValidationResponse !== null) {
                return $userValidationResponse;
            }

            // Validar la contraseña
            $passwordValidationResponse = $codigoService->validatePassword($request);
            if ($passwordValidationResponse !== null) {
                return $passwordValidationResponse;
            }

            // Crear usuario
            $user = new User();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );
            $user->setUsername($username);

            $userRepository->Save($user);

            // Redirigir a la página de inicio de sesión
            return $security->login($user, UserAuthenticator::class, 'main');
        }

        return $this->render('security/register.html.twig');
    }
}
