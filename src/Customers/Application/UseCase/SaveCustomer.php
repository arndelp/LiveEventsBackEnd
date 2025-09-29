<?php

namespace App\Customers\Application\UseCase;

use Symfony\Component\Mime\Address;
use App\Customers\Domain\Entity\Customer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Customers\Application\DTO\CustomerDTO;
use App\Customers\Application\Mapper\CustomerMapper;
use App\Customers\Infrastructure\Security\EmailVerifier;
use App\Customers\Domain\Repository\CustomerRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Customers\Domain\Repository\EmailDuplicationCheckerInterface;

final class SaveCustomer
{
     public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private CustomerMapper $mapper,
        private UserPasswordHasherInterface $passwordHasher,
        private EmailVerifier $emailVerifier,
        private Security $security,
        private EmailDuplicationCheckerInterface $emailDuplicationChecker,
    ) {}

    public function execute(CustomerDTO $dto): Customer
    {
       //vérifiation que l'email n'est pas vide
        if (empty($dto->email)) {
            throw new \InvalidArgumentException('L\'email est requis et ne peut pas être vide.');
        }
        // Vérification si l'email existe déjà dans la base de données
        if ($this->emailDuplicationChecker->isEmailDuplicate($dto->email)) {
            throw new \InvalidArgumentException('Cet email est déjà utilisé.');
        }

        // Mapping DTO en Entité par le mapper
        $customer = $this->mapper->toEntity($dto);

         // Hash du mot de passe (remplace le setPassword dans le mapper)
        $hashedPassword = $this->passwordHasher->hashPassword($customer, $dto->password);
        $customer->setPassword($hashedPassword);

        // Sauvegarde en base de données
        $this->customerRepository->save($customer);

        // Envoyer l'e-mail de confirmation avec mailerVerifier
        $email = (new TemplatedEmail())
            ->from(new Address('arndelp595@gmail.com', 'Live Events'))
            ->to($customer->getEmail())
            ->subject('Veuillez confirmer votre e-mail')
            ->htmlTemplate('@Customer/confirmation_email.html.twig');

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $customer, $email);


        return $customer;
    }
}
