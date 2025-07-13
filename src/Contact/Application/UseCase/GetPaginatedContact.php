<?php

namespace App\Contact\Application\UseCase;

use App\Contact\Domain\Repository\ContactRepositoryInterface;

class GetPaginatedContact
{
    private ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }
//Appel au repositoryInterface pour utiliser les fonction findPaginated et countAll
    public function execute(int $page, int $limit): array
    {
        $contacts = $this->contactRepository->findPaginated($page, $limit);
        //Pour compter le nombre de page
        $total = $this->contactRepository->countAll();
        $nbrePage = (int) ceil($total / $limit); //ceil: méthode arrondi supérieur

        return[
            'contacts' => $contacts,
            'total' => $total,
            'nbrePage' => $nbrePage,
            'currentPage' => $page,
        ];
    }
}

