<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AlertRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AlertRepository::class)]
#[ApiResource]
#[ApiResource(normalizationContext: ['groups' => ['alert']])]
class Alert
{
    #[ORM\Id]
<<<<<<< HEAD
    #[ORM\Column]
    #[Groups(['alert'])]
    private ?int $id = 1;
=======
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['alert'])]
    private ?int $id = null;
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['alert'])]
    private ?string $Message1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['alert'])]
    private ?string $Message2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }
<<<<<<< HEAD
    public function setId(?int $Id): static
    {
        $this->id = 1;

        return $this;
    }
=======
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763

    public function getMessage1(): ?string
    {
        return $this->Message1;
    }

    public function setMessage1(?string $Message1): static
    {
        $this->Message1 = $Message1;

        return $this;
    }

    public function getMessage2(): ?string
    {
        return $this->Message2;
    }

    public function setMessage2(?string $Message2): static
    {
        $this->Message2 = $Message2;

        return $this;
    }
}
