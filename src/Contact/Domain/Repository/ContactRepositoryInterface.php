<?php

namespace App\Contact\Domain\Repository;

use App\Contact\Domain\Entity\Contact;

interface ContactRepositoryInterface 
{
     public function findById(int $id): ?Contact;
     public function deleteContact(Contact $contact): void;
     public function findPaginated(int $page, int $limit): array;
     public function countAll(): int;
     public function save(Contact $contact): void;
}
