<?php

namespace App\Sponsors\Application\UseCase;

use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;



class GetPaginatedSponsor
{
    private SponsorRepositoryInterface $sponsorRepository;

    public function __construct(SponsorRepositoryInterface $sponsorRepository)
    {
        $this->sponsorRepository = $sponsorRepository;
    }

    public function execute(int $page, int $limit): array
    {
        $sponsors = $this->sponsorRepository->findPaginated($page, $limit);
        $total = $this->sponsorRepository->countAll();
        $nbrePage = (int) ceil($total / $limit);

        return[
            'sponsors' => $sponsors,
            'total' => $total,
            'nbrePage' => $nbrePage,
            'currentPage' => $page,
        ];
    }
}