<?php

namespace App\Sponsors\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Users\Domain\Entity\User;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use App\Sponsors\Infrastructure\Repository\DoctrineSponsorRepository;

#[ORM\Entity(repositoryClass: DoctrineSponsorRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    normalizationContext: ['groups' => 'sponsors'],
    denormalizationContext:  ['groups' => 'sponsors']
)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sponsors'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['sponsors'])]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['sponsors'])]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'sponsors')]
    private ?User $createdBy = null;

    #[ORM\Column(length: 255, nullable: true)]   
    #[Groups(['sponsors'])]     
    private ?string $logoSponsorId = null;

    #[Vich\UploadableField(mapping: 'sponsors', fileNameProperty: 'logoSponsorId')]   
    #[Assert\Image()]   
    private ?File $logoSponsor =null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
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

    public function getLogoSponsor(): ?File
    {
        Return $this->logoSponsor;
    }

    public function setLogoSponsor(?File $logoSponsor): static  
    {
        $this->logoSponsor = $logoSponsor;
        return $this;
    }

    public function getLogoSponsorId(): ?string
    {
        return $this->logoSponsorId;
    }

    public function setLogoSponsorId(?string $logoSponsorId): static
    {
        $this->logoSponsorId = $logoSponsorId;

        return $this;
    }

    //envoi de l'url complète de l'image à l'API
    #[Groups(['sponsors'])]
    public function getFullImageUrl(): ?string
    {
        return 'https://concertslives.store/uploads/sponsors/' . $this->logoSponsorId;
    }
}
