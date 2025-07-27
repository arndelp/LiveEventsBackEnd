<?php

namespace App\Contact\Application\UseCase;

use InvalidArgumentException;
use App\Contact\Domain\Entity\Contact;
use App\Contact\Application\DTO\ContactMessageInput;
use App\Contact\Domain\Repository\ContactRepositoryInterface;

final class SetContactMessage
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository
    ) {}

    public function execute(ContactMessageInput $dto): void
    {
       
        if (empty($dto->email)) {
            throw new InvalidArgumentException('L\'email est requis et ne peut pas être vide.');
        }

        $contact = new Contact();
        $contact->setLastname($dto->lastname);
        $contact->setFirstname($dto->firstname);
        $contact->setEmail($dto->email);
        $contact->setMessage($dto->message);

        $this->contactRepository->save($contact);
    }
}
