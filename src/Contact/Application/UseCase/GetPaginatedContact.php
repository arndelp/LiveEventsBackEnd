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
        return[
            'contacts' => $contacts,
            'total' => $total,
            'nbrePage' => $nbrePage,
            'currentPage' => $page,
        ];
    }
}

