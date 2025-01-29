<?php

declare(strict_types=1);

namespace App\Document;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;



#[ODM\Document(collection: 'stages')]
#[ApiResource]
#[GetCollection(extraProperties: ['doctrineMongodb' => ['execute_options' => ['allowDiskUse' => true]]])]
#[Vich\Uploadable()]
class Stage
{
    #[ODM\Id(strategy: 'INCREMENT')]
    public ?int $id = null;

    #[ODM\Field]
    public ?string $key = null;

       
    #[ODM\Field]
    public ?string $info = null;

    #[ODM\FIeld]
    #[Assert\NotBlank]
    public ?float $lat = null;

    #[ODM\Field]
    #[Assert\NotBlank]
    public ?float $lng = null;   

    #[ODM\Field]
    public ?string $image = null;

    #[ODM\Field]
    public ?string $width = null;

    #[ODM\Field]
    public ?string $height = null;

    #[Vich\UploadableField(mapping: 'markers', fileNameProperty: 'image')]   
    #[Assert\Image( )]   
    private ?File $icone =null;


    public function getId(): int
    {
        return $this->id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key) 
    {
        $this->key = $key;

        return $this;
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function setInfo(string $info)
    {
        $this->info = $info;

        return $this;
    }

    public function getLat(): float
    {
        return $this->lat;
    }

    public function setLat(float $lat)
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function setLng(float $lng)
    {
        $this->lng = $lng;

        return $this;
    }
    

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width)
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height)
    {
        $this->height = $height;

        return $this;
    }

    public function getIcone(): ?File
    {
        Return $this->icone;
    }

    public function setIcone(?File $icone): static  
    {
        $this->icone = $icone;
        return $this;
    }

    public function getFullImageUrl(): ?string
    {
        return 'http://127.0.0.1:8000/uploads/markers/' . $this->image;
    }
}