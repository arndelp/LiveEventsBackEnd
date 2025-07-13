<?php

namespace App\Contact\Application\UseCase;


use App\Contact\Domain\Entity\Contact;
use App\Contact\Domain\Repository\ContactRepositoryInterface;

// uniquement une récupération d'un contact par Id => pas de DTO

class GetContact
{
    public function __construct(private ContactRepositoryInterface $contactRepository, ) {}

    public function execute(int $id): ?Contact
    { 

        $contact = $this->contactRepository->findById($id);
    
    return $contact;    
    }
}