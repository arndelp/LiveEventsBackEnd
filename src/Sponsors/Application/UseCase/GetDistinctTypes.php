<?php
namespace App\Sponsors\Application\UseCase;

use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;

class GetDistinctTypes
{
    public function __construct(private SponsorRepositoryInterface $sponsorRepository) {}

    public function execute(): array
    {
        return [
            'types' => $this->sponsorRepository->findDistinctTypes()
        ];
    }
}
