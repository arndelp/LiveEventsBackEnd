<?php

namespace App\Customers\Application\UseCase;

use App\Customers\Domain\Repository\CustomerRepositoryInterface;

class GetPaginatedCustomer
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
//Appel au repositoryInterface pour utiliser les fonction findPaginated et countAll
    public function execute(int $page, int $limit): array
    {
        return $this->customerRepository->findPaginated($page, $limit);
    }
}

