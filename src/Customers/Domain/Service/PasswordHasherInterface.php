<?php

namespace App\Customers\Domain\Service;

use App\Customers\Domain\Entity\Customer;



interface PasswordHasherInterface
{
    public function isPasswordValid(Customer $customer, string $password): bool;
}
