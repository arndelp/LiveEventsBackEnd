<?php

namespace App\Customers\Infrastructure\Service;



use App\Customers\Domain\Entity\Customer;
use App\Customers\Domain\Service\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SymfonyPasswordHasher implements PasswordHasherInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function isPasswordValid(Customer $customer, string $password): bool
    {
        return $this->hasher->isPasswordValid($customer, $password);
    }
}
