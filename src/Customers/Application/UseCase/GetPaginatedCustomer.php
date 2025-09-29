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
        $customers = $this->customerRepository->findPaginated($page, $limit);
        //Pour compter le nombre de page
        $total = $this->customerRepository->countAll();
        $nbrePage = (int) ceil($total / $limit); //ceil: méthode arrondi supérieur

        return[
            'customers' => $customers,
            'total' => $total,
            'nbrePage' => $nbrePage,
            'currentPage' => $page,
        ];
    }
}

