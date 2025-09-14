<?php
namespace App\Sponsors\Application\UseCase;

use App\Sponsors\Application\DTO\SponsorFilterDTO;
use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;

class GetFilteredSponsors
{
    public function __construct(private SponsorRepositoryInterface $sponsorRepository) {}
    //Reçoit un DTO de filtre et délègue au repository
    public function execute(SponsorFilterDTO $filter, int $page, int $limit): array
    {
        return $this->sponsorRepository->findByFilters($filter, $page, $limit);
    }
}
