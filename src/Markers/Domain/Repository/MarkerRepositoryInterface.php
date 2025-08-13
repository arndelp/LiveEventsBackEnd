<?php

namespace App\Markers\Domain\Repository;

use App\Markers\Domain\Entity\Marker;

interface MarkerRepositoryInterface
{
    public function findByFilters(MarkerFilterDTO $filter, int $page, int $limit): array;
    public function countAll(): int;
    public function findById(int $id): ?Marker;
    public function saveMarker(Marker $marker): void;
    public function deleteMarker(int $id): void;
}
