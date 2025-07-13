<?php
namespace App\Markers\Application\UseCase;

use App\Markers\Domain\Repository\MarkerRepositoryInterface;

class DeleteMarker
{
    public function __construct(private MarkerRepositoryInterface $markerRepository) {}

    public function execute(int $id): void
    {
        $marker = $this->markerRepository->findById($id);

        if ($marker) {
            $this->markerRepository->deleteMarker($id);
        }
        // Tu peux gérer le cas où le marker n'existe pas (optionnel)
    }
}
