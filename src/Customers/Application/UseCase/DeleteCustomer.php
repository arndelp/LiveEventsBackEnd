<?php

namespace App\Customers\Application\UseCase;

use App\Customers\Domain\Repository\CustomerRepositoryInterface;

class DeleteCustomer
{
    public function __construct(private CustomerRepositoryInterface $customerRepository) {}

    public function execute(int $id): void
    {
    //Appel au repositoryInterface pour utiliser les fonction findById et deleteCustomer
            
        $customer = $this->customerRepository->findById($id);

        if(!$customer) {
            return ;   // utile pour le test
        }
        
        $this->customerRepository->deleteCustomer($customer);
    }
}