<?php

namespace App\Concerts\Domain\Entity;

 

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Users\Domain\Entity\User;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Concerts\Infrastructure\Repository\DoctrineConcertRepository;





#[ORM\Entity(repositoryClass:DoctrineConcertRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'concerts'],
    denormalizationContext:  ['groups' => 'concerts']
)]
#[Vich\Uploadable]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]  
    #[Groups(['concerts'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]     
    #[Groups(['concerts'])]
    private ?string $name = null;

          
    #[Groups(['concerts'])]
    private ?string $style = null;   

    #[ORM\Column(type: Types::TEXT)]      
    #[Groups(['concerts'])]
    private ?string $details = null;

    #[ORM\Column(type: Types::TEXT)]       
    #[Groups(['concerts'])]
    private ?string $details2 = null;

    #[ORM\Column(length: 30, nullable: true)]    
    #[Groups(['concerts'])]
    private ?string $location = null;

    #[ORM\Column(length: 30, nullable: true)]      
    #[Groups(['concerts'])]
    private ?string $day = null;

    #[ORM\Column(length: 30, nullable: true)]     
    #[Groups(['concerts'])]
    private ?string $schedule = null;

   
    #[ORM\Column(length: 255, nullable: true)]   
    #[Groups(['concerts'])]     
    private ?string $imageId = null;

    #[Vich\UploadableField(mapping: 'concerts', fileNameProperty: 'imageId')]   
    #[Assert\Image()]    
    #[Groups(['concerts'])]
    private ?File $photo =null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[Groups(['concerts'])]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'concertModif')]
    #[Groups(['concerts'])]
    private ?User $modifiedBy = null;

   
 
    
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
    #[Groups(['concerts'])]
    public function getFullImageUrl(): ?string
    {
        return 'https://concertslives.store/uploads/concerts/' . $this->imageId;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): static
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }
}
