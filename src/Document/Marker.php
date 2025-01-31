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




#[ApiResource]
#[ODM\Document]
class Marker
{
    

    #[ODM\Id(strategy: 'INCREMENT')]
    public string $id;

    #[ODM\Field(nullable: true)]
    public string $name;

    #[ODM\Field(nullable: true)]
    public int $zIndex;

    
    #[ODM\Field(nullable: true)]
    public string $type;

    
    #[EmbedOne(targetDocument:Position::class)]
    #[Assert\Valid]
    private ?Position $position;

    
    
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type) 
    {
        $this->type = $type;

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

    public function getZIndex(): int
    {
        return $this->zIndex;
    }

    public function setZIndex(int $zIndex) 
    {
        
        $this->zIndex=$zIndex;

        return $this;
    } 
   
}


   

    
