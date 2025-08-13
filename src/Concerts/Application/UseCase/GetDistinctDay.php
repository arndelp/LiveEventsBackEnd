<?php
namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

class GetDistinctDay
{
    public function __construct(private ConcertRepositoryInterface $concertRepository) {}

    public function execute(): array
    {
        return $this->concertRepository->findDistinctDays();
    }
}
