<?php

namespace App\Service;

use App\Entity\User;
use App\Exception\UserAlreadyExistsException;
use App\Model\IdResponse;
use App\Model\SignUpRequest;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpService
{
    public function __construct(private UserPasswordHasherInterface $hasher,
                                private AuthenticationSuccessHandler $successHandler,
                                private UserRepository $userRepository)
    {
    }

    public function signUp(SignUpRequest $request): Response
    {
        if ($this->userRepository->existsByEmail($request->getEmail())) {
            throw new UserAlreadyExistsException();
        }

        $user = (new User())
            ->setEmail($request->getEmail())
            ->setRoles(['ROLE_USER']);


        $user->setPassword($this->hasher->hashPassword($user, $request->getPassword()));

        $this->userRepository->save($user, true);

        return $this->successHandler->handleAuthenticationSuccess($user);

    }
}
