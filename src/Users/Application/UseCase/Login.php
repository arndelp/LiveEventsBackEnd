<?php
namespace App\Users\Application\UseCase;

use App\Users\Application\DTO\LoginResponse;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class Login
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private readonly AuthenticationUtils $authenticationUtils
    ) {}

    public function execute(): LoginResponse
    {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $lastError = $this->authenticationUtils->getLastAuthenticationError();

        if ($lastUsername) {
            $user = $this->userRepository->findOneByEmail($lastUsername);

            if ($user && !$user->isVerified()) {
                // Option 1 : Lever une exception spécifique
                throw new CustomUserMessageAuthenticationException(
                    'Vous devez vérifier votre email avant de vous connecter.'
                );
            }
        }

        return new LoginResponse($lastUsername, $lastError);
    }
}
