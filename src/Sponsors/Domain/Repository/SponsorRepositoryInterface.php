<?php

namespace App\Sponsors\Domain\Repository;

use App\Sponsors\Domain\Entity\Sponsor;
use App\Sponsors\Application\DTO\SponsorFilterDTO;

interface SponsorRepositoryInterface
{
    public function findByFilters(SponsorFilterDTO $filter, int $page, int $limit): array;
    public function countAll(): int;
    public function findById(int $id): ?Sponsor;
    public function saveSponsor(Sponsor $sponsor): void;
    public function deleteSponsor(int $id): void;
}
