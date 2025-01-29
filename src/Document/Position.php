<?php

namespace App\Document;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;


#[EmbeddedDocument]
class Position
{    
    #[Assert\NotBlank]
    private float $lat;
    
    #[Assert\NotBlank]
    private float $lng;

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