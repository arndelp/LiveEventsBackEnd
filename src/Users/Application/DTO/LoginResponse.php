<?php

// src/Security/Application/DTO/LoginResponse.php

namespace App\Security\Application\DTO;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginResponse
{
    public function __construct(
        public readonly ?string $email,
        public readonly ?AuthenticationException $error
    ) {}
}
