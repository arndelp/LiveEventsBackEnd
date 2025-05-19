<?php

namespace App\Entity;

 

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConcertRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: ConcertRepository::class)]
#[ApiResource( paginationItemsPerPage: 50)]   // Limitation par défault d'API Platform à 30 Items
#[Vich\Uploadable()]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]        
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\NotBlank]       
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]        
    private ?string $style = null;   

    #[ORM\Column(type: Types::TEXT)]   
    private ?string $details = null;

    #[ORM\Column(type: Types::TEXT)]     
    private ?string $details2 = null;

    #[ORM\Column(length: 30, nullable: true)]        
    private ?string $location = null;

    #[ORM\Column(length: 30, nullable: true)]        
    private ?string $day = null;

    #[ORM\Column(length: 30, nullable: true)]        
    private ?string $schedule = null;

   
    #[ORM\Column(length: 255, nullable: true)]        //les contraintes de l'image se font dans ConcertType     
    private ?string $imageId = null;

    #[Vich\UploadableField(mapping: 'concerts', fileNameProperty: 'imageId')]   
    #[Assert\Image()]  
    private ?File $photo =null;

   

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): static
    {
        $this->style = $style;

        return $this;
    }
   
  
    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getDetails2(): ?string
    {
        return $this->details2;
    }

    public function setDetails2(?string $details2): static
    {
        $this->details2 = $details2;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(?string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): static
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getImageId(): ?string
    {
        return $this->imageId;
    }

    public function setImageId(?string $imageId): static
    {
        $this->imageId = $imageId;

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
//envoi de l'url complète de l'image à l'API
    #[Groups(['concert'])]
    public function getFullImageUrl(): ?string
    {
        return 'https://concertslives.store/uploads/concerts/' . $this->imageId;
    }
}
