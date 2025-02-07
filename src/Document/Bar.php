<?php



namespace App\Document;


use MongoDB\Collection;
use App\Document\Position;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbedOne;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Doctrine\ODM\MongoDB\Mapping\Annotations\EmbeddedDocument;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[Vich\Uploadable()]
#[ApiResource]
#[ODM\Document]
class Bar
{
    

    #[ODM\Id(strategy: 'INCREMENT')]
    public string $id;

    #[ODM\Field(nullable: true)]
    public string $name;

         
    #[EmbedOne(targetDocument:Position::class)]
    #[Assert\Valid]
    private ?Position $position;

    #[ODM\Field(nullable: true)]  
    private ?string $iconId = null;

    #[Vich\UploadableField(mapping: 'markers', fileNameProperty: 'iconId')]   
    #[Assert\Image()]    
    private ?File $photo =null;

    #[ODM\Field(nullable: true)]
    public int $width;

    #[ODM\Field(nullable: true)]
    public int $height;

    #[ODM\Field(nullable: true)]
    public string $info;








    
    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): void
    {
        $this->position = $position;
    }
   

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(): string
    {
        $this->id = $id;

        return $this;
    }

    

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name) 
    {
        $this->name = $name;

        return $this;
    } 

    

   

    public function getIconId(): ?string
    {
        return $this->iconId;
    }

    public function setIconId(?string $iconId): static
    {
        $this->iconId = $iconId;

        return $this;
    }

    public function getPhoto(): ?File
    {
        Return $this->photo;
    }

    public function setPhoto(?File $photo): static  
    {
        $this->photo = $photo;
        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): static
    {
        $this->height = $height;

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
    
//envoi de l'url complète de l'image à l'API
    
    public function getFullIconUrl(): ?string
    {
        return 'http://127.0.0.1:8000/uploads/markers/' . $this->iconId;
    }
   
}


   

    
