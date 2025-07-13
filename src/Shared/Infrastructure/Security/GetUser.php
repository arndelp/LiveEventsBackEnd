<?php

namespace App\Shared\Infrastructure\Security;

use App\Users\Domain\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use App\Shared\Domain\Security\GetUserInterface;


class GetUser implements GetUserInterface
{
    public function __construct(private Security $security) {}

    public function getUser(): User {
        return $this->security->getUser();
    }
}