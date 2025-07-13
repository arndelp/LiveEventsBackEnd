<?php

namespace App\Markers\Application\DTO;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class MarkerDTO
{
    public ?int $id = null;

    #[Assert\Length(
        max: 100,
        maxMessage: '100 caractères au maximum',
        )]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]    
    public ?string $name = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]  
    #[Assert\Regex(pattern:'/^[0-9_.]+$/i', htmlPattern: '^[0-9_.]+$', message: "La valeur doit être de type 48.6XXXXXXXXXXXX")]        
    #[Assert\Length(        
        max: 20,        
        maxMessage: '20 caractères au maximum',
    )] 
    public ?string $latitude = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]  
    #[Assert\Regex(pattern:'/^[0-9_.]+$/i', htmlPattern: '^[0-9_.]+$', message: "La valeur doit être de type 1.8XXXXXXXXXXXX")]        
    #[Assert\Length(        
        max: 20,        
        maxMessage: '20 caractères au maximum',
    )] 
    public ?string $longitude = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")] 
    public ?string $type = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]    
    #[Assert\Length(        
        max: 600,        
        maxMessage: '600 caractères au maximum',
    )] 
    public ?string $details = null;

    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    public ?int $zIndex = null;

}