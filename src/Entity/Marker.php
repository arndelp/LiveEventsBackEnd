<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MarkerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MarkerRepository::class)]
#[ApiResource]
class Marker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Regex(pattern:'/^[0-9_.]+$/i', htmlPattern: '^[0-9_.]+$', message: "La valeur doit être de type 48.6XXXXXXXXXXXX")] 
    #[Assert\Length(max: 20, maxMessage: '20 caractères au maximum')]  
    private ?string $latitude = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Regex(pattern:'/^[0-9_.]+$/i', htmlPattern: '^[0-9_.]+$', message: "La valeur doit être de type 1.8XXXXXXXXXXXX")] 
    #[Assert\Length(max: 20, maxMessage: '20 caractères au maximum')]  
    private ?string $longitude = null;

       
    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    #[Assert\Length(max: 50, maxMessage: '50 caractères au maximum')]
    private ?string $details = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez remplir ce champ")]
    private ?int $zIndex = null;
   

    

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

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

 

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

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
    
    public function getZIndex(): ?int
    {
        return $this->zIndex;
    }

    public function setZIndex(?int $zIndex): static
    {
        $this->zIndex = $zIndex;

        return $this;
    }

    
   
 
}
