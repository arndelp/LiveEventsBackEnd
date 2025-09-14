<?php

namespace App\Concerts\Domain\Repository;

use App\Concerts\Domain\Entity\Concert;
use App\Concerts\Application\DTO\ConcertFilterDTO;

interface ConcertRepositoryInterface
{
    public function findByFilters(ConcertFilterDTO $filter,int $page, int $limit  ) : array;    
    public function countAll(): int;
    public function findById(int $id): ?Concert;
    public function saveConcert(Concert $concert): void;
    public function deleteConcert(int $id): void;
    public function findDistinctSchedules(): array;
    public function findDistinctDays(): array;
    public function findDuplicateByDateLocationSchedule(string $day, string $location,string $schedule,?int $excludeId = null): ?bool ;    
}
