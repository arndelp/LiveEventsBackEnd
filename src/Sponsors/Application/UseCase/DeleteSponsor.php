<?php
namespace App\Sponsors\Application\UseCase;

use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;

class DeleteSponsor
{
    public function __construct(private SponsorRepositoryInterface $sponsorRepository) {}

    public function execute(int $id): void
    {
        $sponsor = $this->sponsorRepository->findById($id);

        if ($sponsor) {
            $this->sponsorRepository->deleteSponsor($id);
        }
        // Tu peux gérer le cas où le sponsor n'existe pas (optionnel)
    }
}
