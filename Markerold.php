<?php

declare(strict_types=1);

namespace App\Document;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;


#[ODM\Document(collection: 'markers')]
#[ApiResource]
#[GetCollection(extraProperties: ['doctrineMongodb' => ['execute_options' => ['allowDiskUse' => true]]])]
#[Vich\Uploadable()]
class Markerold
{
    #[ODM\Id(strategy: 'INCREMENT')]
    public ?string $id = null;

    #[ODM\Field(nullable: false)]
    public ?int $zIndex = null;

    #[ODM\Field(nullable: false)]
    public ?string $type = null;

    #[ODM\Field(nullable: true)]
    #[Assert\NotBlank] 
    public ?string $name = null;

    #[ODM\FIeld(nullable: false)]
    #[Assert\NotBlank]
    public ?float $lat = null;

    #[ODM\Field(nullable: false)]
    #[Assert\NotBlank]
    public ?float $lng = null;  

    #[ODM\Field(nullable: true)]
    public ?string $info = null;


    #[ODM\Field(nullable: true)]
    public ?string $image = null;

    #[ODM\Field(nullable: true)]
    public ?string $width = null;

    #[ODM\Field(nullable: true)]
    public ?string $height = null;

    #[Vich\UploadableField(mapping: 'markers', fileNameProperty: 'image')]   
    #[Assert\Image( )]   
    private ?File $icone =null;

    

    

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id) 
    {
        $this->id = $id;

        return $this;
    } 

    public function getZIndex(): int
    {
        return $this->zIndex;
    }

    public function setZIndex(int $zindex) 
    {
        $this->zIndex = $zIndex;

        return $this;
    } 

    

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type) 
    {
        $this->type = $type;

        return $this;
    }  


    public function getInfo(): string
    {
        return $this->info;
    }

    public function setInfo(string $info): static
    {
        $this->info = $info;

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





   
