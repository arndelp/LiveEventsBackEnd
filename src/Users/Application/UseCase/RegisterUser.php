<?php

namespace App\Users\Application\UseCase;

use App\Users\Domain\Entity\User;
use Symfony\Component\Mime\Address;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Users\Application\DTO\RegisterUserInputDto;
use App\Users\Application\Mapper\RegisterUserMapper;
use App\Users\Infrastructure\Security\EmailVerifier;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EmailVerifier $emailVerifier,
        private Security $security,
    
    ) {}

    public function execute(RegisterUserInputDto $dto): User
    {
        // Mapper le DTO vers une entité
        $user = RegisterUserMapper::toEntity($dto);

        // Hasher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $dto->getPassword());
        $user->setPassword($hashedPassword);

        // Persister l'utilisateur
        $this->userRepository->save($user);

     
        // Envoyer l'e-mail de confirmation avec mailerVerifier
        $email = (new TemplatedEmail())
            ->from(new Address('arndelp595@gmail.com', 'Live Events'))
            ->to($user->getEmail())
            ->subject('Veuillez confirmer votre e-mail')
            ->htmlTemplate('@User/confirmation_email.html.twig');

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, $email);

        return $user;
    }
}
