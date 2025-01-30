<?php
declare(strict_types=1);
namespace App\Document;



use ODM\Field;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;



#[EmbeddedDocument]
class Position
{    
    
    #[Assert\NotBlank]
    #[ODM\Field(nullable: true)]
    public float $lat;
    
    
    #[Assert\NotBlank]
    #[ODM\Field(nullable: true)]
    public float $lng;

    
    
}