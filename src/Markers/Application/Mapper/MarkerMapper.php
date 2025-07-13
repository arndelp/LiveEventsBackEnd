<?php

namespace App\Markers\Application\Mapper;

use App\Markers\Domain\Entity\Marker;
use App\Markers\Application\DTO\MarkerDTO;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;

class MarkerMapper
{
    public function toEntity(MarkerDTO $dto, MarkerRepositoryInterface $markerRepository): Marker
    {
        // Si Marker existant
        if ($dto->id) {
            // Récupère le Marker existant depuis la base
            $marker = $markerRepository->findById($dto->id);
            if (!$marker) {
                // Message d'erreur enregistré dans error.log de nginx (/var/log/nginx/error.log), visible dans le navigateur uniquement en développement
                throw new \Exception("Marker non trouvé pour mise à jour.");
            }
        } else {
            $marker = new Marker();
        }

        // Mise à jour des champs
        $marker->setName($dto->name);
        $marker->setLatitude($dto->latitude);
        $marker->setLongitude($dto->longitude);
        $marker->setType($dto->type);
        $marker->setDetails($dto->details);
        $marker->setZIndex($dto->zIndex);
       

        return $marker;
    }
    //Pour la récupération des données déjà enregistrées
    public function toDTO(Marker $marker): MarkerDTO
    {
        $dto = new MarkerDTO();
        $dto->id = $marker->getId(); // 👈 important pour l'update
        $dto->name = $marker->getName();
        $dto->latitude = $marker->getLatitude();
        $dto->longitude = $marker->getLongitude();
        $dto->type = $marker->getType();
        $dto->details = $marker->getDetails();
        $dto->zIndex = $marker->getZIndex();
        

        return $dto;
    }
}