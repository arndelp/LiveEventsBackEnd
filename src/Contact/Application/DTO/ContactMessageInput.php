<?php

namespace App\Contact\Application\DTO;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ContactMessageInput
{
    
    #[Assert\NotBlank(message: "Le nom est requis.")]
    public ?string $lastname = null;

    #[Assert\NotBlank(message: "Le prénom est requis.")]
    public ?string $firstname = null;

    
    #[Assert\NotBlank(message: "L'email est requis.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    public ?string $email = null;

  
    #[Assert\NotBlank(message: "Le message ne peut pas être vide.")]
    public ?string $message = null;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        string $message
    ) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->message = $message;
    }
    /*
        Dans un DTO, le constructeur sert à garantir :
            la complétude des données,
            un contrat clair (tous les champs obligatoires sont fournis dès le départ),
            une meilleure robustesse (moins d’objets « incomplets » qui circulent dans ton appli).
    */
}
