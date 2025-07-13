<?php

namespace App\Alert\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Alert\Infrastructure\Repository\DoctrineAlertRepository;

#[ORM\Entity(repositoryClass: DoctrineAlertRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => 'alert'],  //lecture
    denormalizationContext:  ['groups' => 'alert']   //écriture
)]

class Alert
{
    #[ORM\Id]
    #[ORM\Column] 
    #[Groups(['alert'])]  
    private ?int $id = 1;

    #[ORM\Column(length: 255, nullable: true)]  
    #[Groups(['alert'])] 
    private ?string $message1 = null;

    #[ORM\Column(length: 255, nullable: true)]    
    #[Groups(['alert'])] 
    private ?string $message2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $Id): static
    {
        $this->id = 1;

        return $this;
    }

    public function getMessage1(): ?string
    {
        return $this->message1;
    }

    public function setMessage1(?string $message1): static
    {
        $this->message1 = $message1;

        return $this;
    }

    public function getMessage2(): ?string
    {
        return $this->message2;
    }

    public function setMessage2(?string $message2): static
    {
        $this->message2 = $message2;

        return $this;
    }
}
