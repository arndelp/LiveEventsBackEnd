<?php
namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

class GetDistinctSchedule
{
    public function __construct(private ConcertRepositoryInterface $concertRepository) {}

    public function execute(): array
    {
        return $this->concertRepository->findDistinctSchedules();
    }
}
