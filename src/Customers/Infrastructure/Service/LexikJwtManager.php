<?php

namespace App\Customers\Infrastructure\Service;


use App\Customers\Domain\Entity\Customer;
use App\Customers\Domain\Service\JwtManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class LexikJwtManager implements JwtManagerInterface
{
    public function __construct(private JWTTokenManagerInterface $jwtManager) {}

    public function create(Customer $customer): string
    {
        return $this->jwtManager->create($customer);
    }
}
