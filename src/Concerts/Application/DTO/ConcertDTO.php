<?php

namespace App\Concerts\Application\DTO;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class ConcertDTO
{
    public ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(       
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )] 
    public ?string $name = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(max: 100)]
    public ?string $style = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(        
        max: 600,        
        maxMessage: '600 caractères au maximum',
    )] 
    public ?string $details = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(        
        max: 600,        
        maxMessage: '600 caractères au maximum',
    )] 
    public ?string $details2 = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    public ?string $location = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    public ?string $day = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    public ?string $schedule = null;

    #[Assert\Image(
        maxSize: '0.99M', // taille maximale 1 Mo
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/avif'],
        mimeTypesMessage: 'Les formats autorisés sont : JPEG, PNG, WEBP, AVIF',
        maxSizeMessage: 'La taille maximale autorisée est de 1 Mo'
    )]
    public ?File $photo = null;
       
}