<?php

namespace App\Alert\Application\DTO;



use Symfony\Component\Validator\Constraints as Assert;

class AlertDTO
{

    public ?int $id = 1;
    
    #[Assert\Length(        
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )]    
    public ?string $message1 = null;

    #[Assert\Length(        
        max: 50,        
        maxMessage: '50 caractères au maximum',
    )]    
    public ?string $message2 = null;
}
