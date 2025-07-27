<?php

namespace App\Contact\Application\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ContactMessageInput
{
    #[Assert\NotBlank(message: "Le nom est requis.")]
    #[Groups(['contact'])]
    public ?string $lastname = null;

    #[Assert\NotBlank(message: "Le prénom est requis.")]
    #[Groups(['contact'])]
    public ?string $firstname = null;

    #[Assert\NotBlank(message: "L'email est requis.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Groups(['contact'])]
    public ?string $email = null;

    #[Assert\NotBlank(message: "Le message ne peut pas être vide.")]
    #[Groups(['contact'])]
    public ?string $message = null;

    public function __construct(
        ?string $firstname = null,
        ?string $lastname = null,
        ?string $email = null,
        ?string $message = null
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->message = $message;
    }
}
