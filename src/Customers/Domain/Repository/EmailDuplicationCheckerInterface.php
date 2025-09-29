<?php

namespace App\Customers\Domain\Repository;

interface EmailDuplicationCheckerInterface
{
    public function isEmailDuplicate(string $email): bool;
}
