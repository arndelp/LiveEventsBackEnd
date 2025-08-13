<?php

namespace App\Sponsors\Application\Mapper;

use App\Sponsors\Domain\Entity\Sponsor;
use App\Sponsors\Application\DTO\SponsorDTO;
use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;

class SponsorMapper
{
    //transformation des données venant du formulaire en dto
    public function toEntity(SponsorDTO $dto, SponsorRepositoryInterface $sponsorRepository): Sponsor
    {
       //S’il y a un id dans le DTO → on suppose qu’on veut mettre à jour un sponsor existant.
        if ($dto->id) {
            // Récupère le sponsor existant dans la base par son id
            $sponsor = $sponsorRepository->findById($dto->id);
            if (!$sponsor) {
                // Message d'erreur enregistré dans error.log de nginx (/var/log/nginx/error.log), visible dans le navigateur uniquement en développement
                throw new \Exception("Sponsor non trouvé pour mise à jour.");
            }
            //sinon création d'un nouveau sponsor
        } else {
            $sponsor = new Sponsor();
        }

        // Mise à jour des champs
        //on copie les valeur du dto vers l'entité
        $sponsor->setName($dto->name);
        $sponsor->setLink($dto->link);        
        $sponsor->setLogoSponsor($dto->logoSponsor);
        

        return $sponsor;
    }
    //Pour la récupération des données déjà enregistrées dans la base . 
    public function toDTO(Sponsor $sponsor): SponsorDTO
    {
        $dto = new SponsorDTO();
        $dto->id = $sponsor->getId(); // 👈 important pour l'update
        $dto->name = $sponsor->getName();
        $dto->link = $sponsor->getLink();        
        $dto->logoSponsor = $sponsor->getLogoSponsor();
        

        return $dto;
    }
}