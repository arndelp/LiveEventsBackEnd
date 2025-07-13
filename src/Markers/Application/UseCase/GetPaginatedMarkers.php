<?php

namespace App\Markers\Application\UseCase;

use App\Markers\Domain\Repository\MarkerRepositoryInterface;



class GetPaginatedMarkers
{
    private MarkerRepositoryInterface $markerRepository;

    public function __construct(MarkerRepositoryInterface $markerRepository)
    {
        $this->markerRepository = $markerRepository;
    }

    public function execute(int $page, int $limit): array
    {
        $markers = $this->markerRepository->findPaginated($page, $limit);
        $total = $this->markerRepository->countAll();
        $nbrePage = (int) ceil($total / $limit);

        return[
            'markers' => $markers,
            'total' => $total,
            'nbrePage' => $nbrePage,
            'currentPage' => $page,
        ];
    }
}