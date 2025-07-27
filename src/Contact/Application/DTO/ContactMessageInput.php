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
        // les 4 paramètres sont utilisés pour initialiser les propriétés de l'objet. 
        // Cela permet de créer un objet ContactMessageInput avec les valeurs spéfiées pour chaque champs,
        //  qui sera ensuite utiliser pour les opération de validation et de traitement dans les cas d'utilisation
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->message = $message;
    }
}
