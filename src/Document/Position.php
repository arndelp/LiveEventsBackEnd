<?php
declare(strict_types=1);
namespace App\Document;



use ODM\Field;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
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
  
   

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }
    
    public function getLng(): float
    {
        return $this->lng;
    }

    public function setLng(float $lng): void
    {
        $this->lng = $lng;
    }
}