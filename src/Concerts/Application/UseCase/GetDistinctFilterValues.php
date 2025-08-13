<?php
namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Repository\ConcertRepositoryInterface;


// Rassemble les deux  findDistinctDays et findDistinctSchedule
class GetDistinctFilterValues
{
    public function __construct(private ConcertRepositoryInterface $concertRepository) {}

    public function execute(): array
    {
        return [
            'days' => $this->concertRepository->findDistinctDays(),
            'schedules' => $this->concertRepository->findDistinctSchedules(),
        ];
    }
}
