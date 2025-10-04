<?php
namespace App\Users\Application\UseCase;

use App\Users\Application\DTO\LoginResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class Login
{
    public function __construct(        
        private readonly AuthenticationUtils $authenticationUtils
    ) {}

    public function execute(): LoginResponse
    {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $lastError = $this->authenticationUtils->getLastAuthenticationError();

      

        return new LoginResponse($lastUsername, $lastError);
    }
}
