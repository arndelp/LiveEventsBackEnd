<?php

namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

class DeleteConcert
{
    public function __construct(private ConcertRepositoryInterface $concertRepository) {}

    public function execute(int $id): void
    {
        //Appel au repositoryInterface pour utiliser les fonction findById et deleteConcert
        $concert = $this->concertRepository->findById($id);
        
        $this->concertRepository->deleteConcert($id);
    }
}