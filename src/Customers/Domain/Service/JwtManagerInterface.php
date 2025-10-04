<?php

namespace App\Customers\Domain\Service;

use App\Customers\Domain\Entity\Customer;



interface JwtManagerInterface
{
    public function create(Customer $customer): string;
}
