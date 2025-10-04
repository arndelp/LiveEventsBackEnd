<?php

namespace App\Customers\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;


class LoginDTO
{
    public function __construct(
        #[Assert\NotBlank(message: "L'email est obligatoire.")]
        #[Assert\Email(message: "L'email n'est pas valide.")]
        public string $email,

        #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
        public string $password
    ) {}
}