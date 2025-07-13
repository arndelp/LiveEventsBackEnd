<?php

namespace App\Concerts\Application\Mapper;

use App\Concerts\Domain\Entity\Concert;
use App\Concerts\Application\DTO\ConcertDTO;
use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

class ConcertMapper
{
    //transformation des données venant du formulaire en dto
    public function toEntity(ConcertDTO $dto, ConcertRepositoryInterface $concertRepository): Concert
    {
       //S’il y a un id dans le DTO → on suppose qu’on veut mettre à jour un concert existant.
        if ($dto->id) {
            // Récupère le concert existant dans la base par son id
            $concert = $concertRepository->findById($dto->id);
            if (!$concert) {
                // Message d'erreur enregistré dans error.log de nginx (/var/log/nginx/error.log), visible dans le navigateur uniquement en développement
                throw new \Exception("Concert non trouvé pour mise à jour.");
            }
            //sinon création d'un nouveau concert
        } else {
            $concert = new Concert();
        }

        // Mise à jour des champs
        //on copie les valeur du dto vers l'entité
        $concert->setName($dto->name);
        $concert->setStyle($dto->style);
        $concert->setDetails($dto->details);
        $concert->setDetails2($dto->details2);
        $concert->setLocation($dto->location);
        $concert->setDay($dto->day);
        $concert->setSchedule($dto->schedule);
        $concert->setPhoto($dto->photo);
        

        return $concert;
    }
    //Pour la récupération des données déjà enregistrées dans la base . 
    public function toDTO(Concert $concert): ConcertDTO
    {
        $dto = new ConcertDTO();
        $dto->id = $concert->getId(); // 👈 important pour l'update
        $dto->name = $concert->getName();
        $dto->style = $concert->getStyle();
        $dto->details = $concert->getDetails();
        $dto->details2 = $concert->getDetails2();
        $dto->location = $concert->getLocation();
        $dto->day = $concert->getDay();
        $dto->schedule = $concert->getSchedule();
        $dto->photo = $concert->getPhoto();
        

        return $dto;
    }
}