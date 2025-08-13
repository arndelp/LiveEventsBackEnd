<?php

namespace App\Sponsors\Application\UseCase;

use App\Sponsors\Domain\Entity\Sponsor;
use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;



class GetSponsor
{
    public function __construct(private SponsorRepositoryInterface $sponsorRepository) {}

    public function execute(int $id): ?Sponsor
    {
    $sponsor = $this->sponsorRepository->findById($id);
        
    return $sponsor;    
    }
}