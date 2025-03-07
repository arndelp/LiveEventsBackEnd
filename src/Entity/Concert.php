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
#[ApiResource(normalizationContext: ['groups' => ['concert']])]
#[Vich\Uploadable()]
class Concert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]    
    #[Groups(['concert'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]   
    #[Groups(['concert'])]  
    private ?string $name = null;
    
    #[ORM\Column(type: Types::TEXT)]    
    #[Groups(['concert'])]
    private ?string $details = null;

    #[ORM\Column(type: Types::TEXT)] 
    #[Groups(['concert'])]   
    private ?string $details2 = null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[ORM\JoinColumn(nullable: true)]    
    #[Groups(['concert'])]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[ORM\JoinColumn(nullable: true)]   
    #[Groups(['concert'])] 
    private ?Day $day = null;

    #[ORM\ManyToOne(inversedBy: 'concerts')]
    #[ORM\JoinColumn(nullable: true)]    
    #[Groups(['concert'])]
    private ?Schedule $schedule = null;

    #[ORM\Column(length: 255, nullable: true)]        //les contraintes de l'image se font dans ConcertType    
    #[Groups(['concert'])]
    private ?string $imageId = null;

    #[Vich\UploadableField(mapping: 'concerts', fileNameProperty: 'imageId')]   
    #[Assert\Image( )]    
    #[Groups(['concert'])]
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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): static
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
        return 'http://127.0.0.1:8000/uploads/concerts/' . $this->imageId;
    }
}
