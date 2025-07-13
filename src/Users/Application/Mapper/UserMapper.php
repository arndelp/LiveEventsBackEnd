<?php

namespace App\Users\Application\Mapper;


use App\Users\Domain\Entity\User;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public static function toEntity(
        UserDTO $dto,
        UserRepositoryInterface $userRepository,
        ?UserPasswordHasherInterface $hasher = null
    ): User {
        if ($dto->id) {
            $user = $userRepository->findById($dto->id);
            if (!$user) {
                throw new \Exception("Utilisateur non trouvé pour mise à jour.");
            }
        } else {
            $user = new User();
        }

        $user->setLastname($dto->lastname);
        $user->setFirstname($dto->firstname);
        $user->setEmail($dto->email);
        $user->setRoles($dto->roles ?? []);
        $user->setIsVerified($dto->isVerified ?? false);

        // Gestion du mot de passe si fourni
        if ($dto->plainPassword && $hasher) {
            $hashedPassword = $hasher->hashPassword($user, $dto->plainPassword);
            $user->setPassword($hashedPassword);
        }

        return $user;
    }

    public static function toDTO(User $user): UserDTO
    {
        $dto = new UserDTO();
        $dto->id = $user->getId();
        $dto->lastname = $user->getLastname();
        $dto->firstname = $user->getFirstname();
        $dto->email = $user->getEmail();
        $dto->roles = $user->getRoles();
        $dto->isVerified = $user->isVerified();

        return $dto;
    }
}
