<?php

namespace App\Customers\Application\UseCase;


use App\Customers\Domain\Entity\Customer;
use App\Customers\Domain\Repository\CustomerRepositoryInterface;

// uniquement une récupération d'un customer par Id => pas de DTO

class GetCustomer
{
    public function __construct(private CustomerRepositoryInterface $customerRepository, ) {}

    public function execute(int $id): ?Customer
    { 

        $customer = $this->customerRepository->findById($id);
    
    return $customer;    
    }
}