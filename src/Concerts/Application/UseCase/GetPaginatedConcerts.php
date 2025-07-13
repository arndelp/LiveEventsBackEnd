<?php

namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Repository\ConcertRepositoryInterface;



class GetPaginatedConcerts
{
    private ConcertRepositoryInterface $concertRepository;
    //injection de dépendance par le constructeur
    public function __construct(ConcertRepositoryInterface $concertRepository)
    {
        $this->concertRepository = $concertRepository;
    }

    public function execute(int $page, int $limit): array
    {
        $concerts = $this->concertRepository->findPaginated($page, $limit);
        //Pour compter le nombre de page
        $total = $this->concertRepository->countAll();
        $nbrePage = (int) ceil($total / $limit); //ceil: méthode pour arrondir à l'entier supérieur

        return[
            'concerts' => $concerts,
            'total' => $total,
            'nbrePage' => $nbrePage,
            'currentPage' => $page,
        ];
    }
}