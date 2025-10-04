<?php

namespace App\Users\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Markers\Domain\Entity\Marker;
use App\Concerts\Domain\Entity\Concert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Users\Infrastructure\Repository\DoctrineUserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: DoctrineUserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 180)]
    private ?string $lastname = null;
    
    #[ORM\Column(length: 180)]
    private ?string $firstname = null;
    
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(name: 'is_verified',type: 'boolean')]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Concert>
     */
    #[ORM\OneToMany(targetEntity: Concert::class, mappedBy: 'createdBy')]
    private Collection $concerts;

    /**
     * @var Collection<int, Concert>
     */
    #[ORM\OneToMany(targetEntity: Concert::class, mappedBy: 'modifiedBy')]
    private Collection $concertModif;

    /**
     * @var Collection<int, Marker>
     */
    #[ORM\OneToMany(targetEntity: Marker::class, mappedBy: 'CreatedBy')]
    private Collection $markers;

    /**
     * @var Collection<int, Marker>
     */
    #[ORM\OneToMany(targetEntity: Marker::class, mappedBy: 'ModifiedBy')]
    private Collection $markersModif;

    public function __construct()
    {
        $this->concerts = new ArrayCollection();
        $this->concertModif = new ArrayCollection();
        $this->markers = new ArrayCollection();
        $this->markersModif = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        
        return $this;
    }
       

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

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
            $concert->setCreatedBy($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): static
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getCreatedBy() === $this) {
                $concert->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Concert>
     */
    public function getConcertModif(): Collection
    {
        return $this->concertModif;
    }

    public function addConcertModif(Concert $concertModif): static
    {
        if (!$this->concertModif->contains($concertModif)) {
            $this->concertModif->add($concertModif);
            $concertModif->setModifiedBy($this);
        }

        return $this;
    }

    public function removeConcertModif(Concert $concertModif): static
    {
        if ($this->concertModif->removeElement($concertModif)) {
            // set the owning side to null (unless already changed)
            if ($concertModif->getModifiedBy() === $this) {
                $concertModif->setModifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Marker>
     */
    public function getMarkers(): Collection
    {
        return $this->markers;
    }

    public function addMarker(Marker $marker): static
    {
        if (!$this->markers->contains($marker)) {
            $this->markers->add($marker);
            $marker->setCreatedBy($this);
        }

        return $this;
    }

    public function removeMarker(Marker $marker): static
    {
        if ($this->markers->removeElement($marker)) {
            // set the owning side to null (unless already changed)
            if ($marker->getCreatedBy() === $this) {
                $marker->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Marker>
     */
    public function getMarkersModif(): Collection
    {
        return $this->markersModif;
    }

    public function addMarkersModif(Marker $markersModif): static
    {
        if (!$this->markersModif->contains($markersModif)) {
            $this->markersModif->add($markersModif);
            $markersModif->setModifiedBy($this);
        }

        return $this;
    }

    public function removeMarkersModif(Marker $markersModif): static
    {
        if ($this->markersModif->removeElement($markersModif)) {
            // set the owning side to null (unless already changed)
            if ($markersModif->getModifiedBy() === $this) {
                $markersModif->setModifiedBy(null);
            }
        }

        return $this;
    }
}
