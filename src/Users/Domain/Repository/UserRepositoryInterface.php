<?php

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findOneByEmail(string $email): ?User;

    public function save(User $user): void;

    public function remove(User $user): void;
}
