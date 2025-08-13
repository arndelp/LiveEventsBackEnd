<?php
namespace App\Markers\Application\UseCase;

use App\Markers\Application\DTO\MarkerFilterDTO;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;

class GetFilteredMarkers
{
    public function __construct(private MarkerRepositoryInterface $markerRepository) {}
    //Reçoit un DTO de filtre et délègue au repository
    public function execute(MarkerFilterDTO $filter, int $page, int $limit): array
    {
        return $this->markerRepository->findByFilters($filter, $page, $limit);
    }
}
