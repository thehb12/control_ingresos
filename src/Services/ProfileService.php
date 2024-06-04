<?php

namespace App\Services;

use App\Controller\MessagesController;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileService extends AbstractController
{
    private UserRepository $userRepository;
    private MessagesController $messagesController;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserRepository $userRepository,
        MessagesController $messagesController,
        UserPasswordHasherInterface $userPasswordHasher,
    ) {
        $this->userRepository = $userRepository;
        $this->messagesController = $messagesController;
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function actualizarPassword(
        Request $request,
        UserInterface $userInterface
    ) {

        if ($this->isPasswordsEmpy($request)) {
            return new JsonResponse(['message' => $this->messagesController->password_change_completed()], 200, ['Content-Type' => 'application/json']);
        }
        if ($this->isnotPasswordsEquals($request)) {
            return new JsonResponse(['message' => $this->messagesController->password_no_match()], 200, ['Content-Type' => 'application/json']);
        }

        $this->savepassword($request, $userInterface);
        return new JsonResponse(['message' => $this->messagesController->password_change_completed()], 200, ['Content-Type' => 'application/json']);
    }

    public function UpdateProfile(
        Request $request,
        UserInterface $userInterface
    ) {
        if ($this->isspaceinblank($request)) {
            return new JsonResponse(['message' => $this->messagesController->space_in_blank()], 200, ['Content-Type' => 'application/json']);
        }


        if ($this->isemailexits($request, $userInterface)) {

            return new JsonResponse(['message' => $this->messagesController->email_already_exists()], 200, ['Content-Type' => 'application/json']);
        }

        $this->saveprofile($request, $userInterface);
        return new JsonResponse(['message' => $this->messagesController->profile_update_completed()], 200, ['Content-Type' => 'application/json']);
    }



    private function isPasswordsEmpy(Request $request): bool
    {
        return $request->request->get('newpassword') == "" || $request->request->get('renewpassword') == "";
    }

    private function isnotPasswordsEquals(Request $request): bool
    {
        return $request->request->get('newpassword') != $request->request->get('renewpassword');
    }


    private function savepassword(Request $request, UserInterface $userInterface)
    {
        $user = $this->userRepository->find($userInterface);
        if ($user instanceof User) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $request->request->get('newpassword')
                )
            );
            $this->userRepository->Save($user);
        }
    }

    private function isspaceinblank(Request $request): bool
    {
        $fullName = $request->request->get('fullName');
        $company = $request->request->get('company');
        $job = $request->request->get('job');
        $email = $request->request->get('email');
        return empty($fullName) || empty($company) || empty($job) || empty($email);
    }

    private function isemailexits(Request $request, UserInterface $userInterface): bool
    {
        
        $user =  $this->userRepository->findOneBy(['email' => $request->request->get('email')]);
        $userLogeado = $this->userRepository->find($userInterface);
        return $user instanceof User && $userLogeado != $user;
    }

    private function saveprofile(Request $request, UserInterface $userInterface)
    {
        $userLogeado = $this->userRepository->find($userInterface);
        if ($userLogeado instanceof User) {
            $userLogeado->setName($request->request->get('fullName'));
            $userLogeado->setBussnies($request->request->get('company'));
            $userLogeado->setJob($request->request->get('job'));
            $userLogeado->setEmail($request->request->get('email'));
            $this->userRepository->Save($userLogeado);
        }
    }
}
