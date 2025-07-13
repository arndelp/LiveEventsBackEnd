<?php

namespace App\Shared\Domain\Security;

use App\Users\Domain\Entity\User;

interface GetUserInterface {
    public function getUser(): User;
}
