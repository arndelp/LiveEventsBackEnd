<?php
namespace App\Concerts\Application\UseCase;

use App\Concerts\Application\DTO\ConcertFilterDTO;
use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

class GetFilteredConcerts
{
    public function __construct(private ConcertRepositoryInterface $concertRepository) {}
    //Reçoit un DTO de filtre et délègue au repository
    public function execute(ConcertFilterDTO $filter, int $page, int $limit): array
    {
        return $this->concertRepository->findByFilters($filter , $page, $limit);
    }
}
