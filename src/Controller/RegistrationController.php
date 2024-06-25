<?php

namespace App\Controller;

use App\Entity\Codigo;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\CodigoRepository;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, CodigoRepository $codigorepository, Security $security, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $username = $request->getPayload()->getString('username');
            $password = $request->getPayload()->getString('password');
            $codigo = $request->getPayload()->getString('codigo');
            if ($username == null || $password == null || $codigo == null) {
                return $this->render('security/register.html.twig');
            };
            $codigo = $codigorepository->findOneBy(['codigo' => $codigo]);
            if (!$codigo instanceof Codigo){
                return $this->render('security/register.html.twig');  
            };



            $user = $userRepository->findOneBy(['username' => $username]);
            if ($user instanceof User) {
                return $this->render('security/register.html.twig');
            }
            $user = new User();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );
            $user->setUsername($username);

            $userRepository->Save($user);
            return $security->login($user, UserAuthenticator::class, 'main');
        };

        return $this->render('security/register.html.twig');
    }
}
