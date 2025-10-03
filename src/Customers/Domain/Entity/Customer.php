<?php

namespace App\Customers\Domain\Entity;

use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Customers\Application\DTO\CustomerDTO;
use App\Customers\UI\Controller\CustomerController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Customers\Infrastructure\Repository\DoctrineCustomerRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: DoctrineCustomerRepository::class)]
#[ApiResource(
    input: CustomerDTO::class,
    normalizationContext: ['groups' => ['customers']],
    formats: ['json'],
    operations: [
        new Post(
            uriTemplate: '/customers',
            controller: CustomerController::class . '::receiveNewCustomer',
            input: CustomerDTO::class,
            output: false,
            name: 'custom_create_customer',
            denormalizationContext: ['groups' => ['customers']]
        )
        
    ]
)]
class Customer implements  UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]    
    #[ORM\Column(type: "integer")]   
    #[Groups(['customers'])]
    private ?int $id = null;

    #[ORM\Column(name: 'lastname',length: 100)]  
    #[Groups(['customers'])]
    private ?string $lastname = null;

    #[ORM\Column(name: 'firstname',length: 100)]   
    #[Groups(['customers'])]
    private ?string $firstname = null;

    #[ORM\Column(name: 'email',length: 100)]
    #[Groups(['customers'])]  
    private ?string $email = null;

    #[ORM\Column(name: 'password',length: 255)]
    #[Groups(['customers'])]
    private ?string $password = null;

    #[ORM\Column(name: 'style',length: 50)]
    #[Groups(['customers'])] 
    private ?string $style = null;

    #[ORM\Column(name: 'streetnumber',length: 10)]
    #[Groups(['customers'])] 
    private ?string $streetnumber = null;

    #[ORM\Column(name: 'street',length: 150)]
    #[Groups(['customers'])]
    private ?string $street = null;

    #[ORM\Column(name: 'postalcode',length: 10)]
    #[Groups(['customers'])]
    private ?string $postalcode = null;

    #[ORM\Column(name: 'city',length: 100)]
    #[Groups(['customers'])]
    private ?string $city = null;

    #[ORM\Column(name: 'country',length: 100)]
    #[Groups(['customers'])]
    private ?string $country = null;

    #[ORM\Column(name: 'phone',length: 25)]
    #[Groups(['customers'])]
    private ?string $phone = null;

    #[ORM\Column(name: 'is_verified',type: 'boolean')]
    #[Groups(['customers'])]
    private bool $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
    
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

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

    public function getStreetnumber(): ?string
    {
        return $this->streetnumber;
    }

    public function setStreetnumber(string $streetnumber): static
    {
        $this->streetnumber = $streetnumber;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): static
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    //Pour compatibilité avec le module Security de symfony

    //Ajout du rôle Customer
    //Pas de colonne ROLE nécessaire étant donné que tout les clients auront les mêmes autorisations
     public function getRoles(): array
    {
        return ['ROLE_CUSTOMER'];
    }

    //identifiant unique
     public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    //Ne sert pas mais attendu par symfony, utile si on stocke un mot de passe en clair
    public function eraseCredentials(): void
    {
        // rien à effacer si pas de mot de passe en clair
    }



}
