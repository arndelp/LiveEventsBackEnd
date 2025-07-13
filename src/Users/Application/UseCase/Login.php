<?php

namespace App\Users\Application\UseCase;

use App\Security\Application\DTO\LoginResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Login
{
    public function __construct(
        private readonly AuthenticationUtils $authenticationUtils
    ) {}

    public function execute(): LoginResponse
    {
        return new LoginResponse(
            $this->authenticationUtils->getLastUsername(),
            $this->authenticationUtils->getLastAuthenticationError()
        );
    }
}