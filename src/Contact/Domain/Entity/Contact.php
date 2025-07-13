<?php

namespace App\Contact\Domain\Entity;

use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Contact\Application\DTO\ContactMessageInput;
use Symfony\Component\Validator\Constraints as Assert;
use App\Contact\UI\Controller\ContactMessageController;
use App\Contact\Domain\Repository\DoctrineContactRepository;

#[ORM\Entity(repositoryClass: DoctrineContactRepository::class)]
#[ApiResource(
    input: ContactMessageInput::class,
    normalizationContext: ['groups' => ['contact']],
    formats: ['json'],
    operations: [
        new Post(
            uriTemplate: '/contacts',
            controller: ContactMessageController::class,
            input: ContactMessageInput::class,
            output: false,
            name: 'custom_create_contact',
            denormalizationContext: ['groups' => ['contact']]
        )
    ]
)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]    
    #[Groups(['contact'])]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]  
    #[Groups(['contact'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 100, nullable: true)]   
    #[Groups(['contact'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['contact'])]  
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['contact'])]   
    private ?string $message = null;

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
    var_dump('Contact setEmail:', $email);
    $this->email = $email;

    return $this;
}

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
