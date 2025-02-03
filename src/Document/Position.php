<?php
declare(strict_types=1);
namespace App\Document;



use ODM\Field;
use Documents\Marker;
use ApiPlatform\Metadata\ApiResource;
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
  
   

    // public function getLat(): float
    // {
    //     return $this->lat;
    // }

    // public function setLat(float $lat)
    // {
    //     $this->lat = $lat;

    //     return $this;
    // }
    
    // public function getLng(): float
    // {
    //     return $this->lng;
    // }

    // public function setLng(float $lng)
    // {
    //     $this->lng = $lng;

    //     return $this;
    // }
}