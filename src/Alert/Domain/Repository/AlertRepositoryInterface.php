<?php

namespace App\Alert\Domain\Repository;

use App\Alert\Domain\Entity\Alert;

interface AlertRepositoryInterface
{
    public function editAlert(Alert $alert): void;
    public function deleteAlert(Alert $alert): void;
    public function findById(int $id): ?Alert;
}
