<?php

namespace App\Concerts\Domain\Repository;

use App\Concerts\Domain\Entity\Concert;

interface ConcertRepositoryInterface
{
    public function findPaginated(int $page, int $limit): array;
    public function countAll(): int;
    public function findById(int $id): ?Concert;
    public function saveConcert(Concert $concert): void;
    public function deleteConcert(int $id): void;
}
