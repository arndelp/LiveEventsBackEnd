<?php

namespace App\Contact\Application\Mapper;

use App\Contact\Domain\Entity\Contact;
use App\Contact\Application\DTO\ContactMessageInput;

class ContactMessageInputMapper
{
public function toEntity(ContactMessageInput $dto): Contact
{
    $contactMessage = new Contact();
    $contactMessage->setFirstname($dto->firstname);
    $contactMessage->setLastname($dto->lastname);
    $contactMessage->setEmail($dto->email);
    $contactMessage->setMessage($dto->message);

    return $contactMessage;
}

public function toDTO(Contact $contact): ContactMessageInput
{
    $dto = new ContactMessageInput();    
    $dto->firstname = $contact->getFirstname();
    $dto->lastname = $contact->getLastname();
    $dto->email = $contact->getEmail();
    $dto->message = $contact->getMessage();

    return $dto;
}

}

