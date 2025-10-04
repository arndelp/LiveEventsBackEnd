<?php

namespace App\Customers\Application\UseCase;


use App\Customers\Application\DTO\LoginDTO;
use App\Customers\Domain\Service\JwtManagerInterface;
use App\Customers\Domain\Service\PasswordHasherInterface;
use App\Customers\Domain\Repository\CustomerRepositoryInterface;



class LoginCustomer
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private PasswordHasherInterface $passwordHasher,
        private JwtManagerInterface $jwtManager
    ) {}

    public function execute(LoginDTO $dto): array
    {
        $customer = $this->customerRepository->findByEmail($dto->$email);

        if (!$customer || !$this->passwordHasher->isPasswordValid($customer, $dto->$password)) {
            throw new \RuntimeException('Identifiants invalides');
        }

        if (!$customer->isIsVerified()) {
            throw new \RuntimeException('Email non vérifié');
        }

        $token = $this->jwtManager->create($customer);

        return [
            'token' => $token,
            'customer' => [
                'id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'style' => $customer->getStyle(),
            ]
        ];
    }
}
