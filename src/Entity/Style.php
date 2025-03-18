<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StyleRepository::class)]
#[ApiResource]
class Style
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('concert')]
    private ?string $style = null;

    /**
     * @var Collection<int, Concert>
     */
    #[ORM\OneToMany(targetEntity: Concert::class, mappedBy: 'style')]
    private Collection $concerts;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStyle(): ?string
    {
        return $this->style ;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;

        return $this;
    }

    

     /**
     * @return Collection<int, Concert>
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): static
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts->add($concert);
            $concert->setStyle($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): static
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getStyle() === $this) {
                $concert->setStyle(null);
            }
        }

        return $this;
    }

    //fonction pour convertir en string
    public function __toString(): string
        {
        return $this-> style;
        }
}


