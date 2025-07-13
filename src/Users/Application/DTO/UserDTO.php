<?php

namespace App\Users\Application\DTO;

class UserDTO
{
    public ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(        
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )] 
    public ?string $lastname = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(        
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )] 
    public ?string $firstname = null;

    #[Assert\Email(message: "Ce n'est pas une adresse e-mail valide.",)]
    #[Assert\Length(        
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )] 
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    public ?string $email = null;
     
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    public ?string $password = null;
}
