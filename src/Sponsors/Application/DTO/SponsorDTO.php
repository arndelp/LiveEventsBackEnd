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

    #[Assert\Image]
    public ?File $logoSponsor = null;


}