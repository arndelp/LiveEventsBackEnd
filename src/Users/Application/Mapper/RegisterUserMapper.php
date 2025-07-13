<?php

namespace App\Users\Application\Mapper;

use App\Users\Application\DTO\RegisterUserInputDto;
use App\Users\Domain\Entity\User;

class RegisterUserMapper
{
    public static function toEntity(RegisterUserInputDto $dto): User
    {
        $user = new User();
        
        // Accès via getters (si propriétés privées dans le DTO)
        $user->setEmail($dto->getEmail());
        $user->setFirstname($dto->getFirstname());
        $user->setLastname($dto->getLastname());

        // Le mot de passe (plain) reste dans le DTO → sera haché dans le UseCase
        // $dto->getPlainPassword() est à traiter dans le UseCase

        return $user;
    }
}
