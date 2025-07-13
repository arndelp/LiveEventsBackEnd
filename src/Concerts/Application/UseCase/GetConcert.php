<?php

namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Entity\Concert;
use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

// uniquement une récupération d'un concert par Id => pas de DTO

class GetConcert
{
    public function __construct(private ConcertRepositoryInterface $concertRepository) {}

    public function execute(int $id): ?Concert
    {
    $concert = $this->concertRepository->findById($id);
        
    return $concert;    
    }
}