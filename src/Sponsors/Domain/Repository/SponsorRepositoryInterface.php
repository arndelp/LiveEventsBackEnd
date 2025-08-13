<?php

namespace App\Sponsors\Domain\Repository;

use App\Sponsors\Domain\Entity\Sponsor;

interface SponsorRepositoryInterface
{
    public function findPaginated(int $page, int $limit): array;
    public function countAll(): int;
    public function findById(int $id): ?Sponsor;
    public function saveSponsor(Sponsor $sponsor): void;
    public function deleteSponsor(int $id): void;
}
