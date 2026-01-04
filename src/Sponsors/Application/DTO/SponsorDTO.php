<?php

namespace App\Sponsors\Application\DTO;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class SponsorDTO
{
    public ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")] 
    #[Assert\Length(        
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )]    
    public ?string $name = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")] 
    #[Assert\Length(        
        max: 100,        
        maxMessage: '100 caractères au maximum',
    )]    
    public ?string $link = null;

    #[Assert\Image(
        maxSize: '500k', 
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/avif'],
        mimeTypesMessage: 'Les formats autorisés sont : JPEG, PNG, WEBP, AVIF',
        maxSizeMessage: 'La taille maximale autorisée est de 500 Ko'
    )]
    public ?File $logoSponsor = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(max: 25)]
    public ?string $type = null;


}