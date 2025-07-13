<?php

namespace App\Markers\Application\UseCase;

use App\Markers\Domain\Entity\Marker;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;



class GetMarker
{
    public function __construct(private MarkerRepositoryInterface $markerRepository) {}

    public function execute(int $id): ?Marker
    {
    $marker = $this->markerRepository->findById($id);
        
    return $marker;    
    }
}