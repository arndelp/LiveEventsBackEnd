<?php

namespace App\Markers\Application\UseCase;

use App\Markers\Domain\Entity\Marker;
use App\Markers\Application\DTO\MarkerDTO;
use App\Markers\Application\Mapper\MarkerMapper;
use App\Shared\Domain\Security\GetUserInterface;  //et non pas userInterface comme en MCV
use App\Markers\Domain\Repository\MarkerRepositoryInterface;

/**Logique métier de création/ou modification d'un Marker */

class SaveMarker
{
    //constructeur avec l'injection de la dépendance MarkerRepositoryInterface (une interface de repository pour ne pas dépendre de doctrine)
    public function __construct(private MarkerRepositoryInterface $markerRepository,private GetUserInterface $getUser, private MarkerMapper $markerMapper) {}
    //execute la méthose appelée par le contrôleur (avec les donné du marker (via $dto), la valeur de $new, les donnée de l'utilisateur qui à créé / modifié)
    public function execute(MarkerDTO $dto, bool $isNew): void
    {
        //Convertion du dto vers l'entité (via le mapper)
        $marker = $this->markerMapper->toEntity($dto, $this->markerRepository);
        
        // Récupération du l'utilisateur  de l'instance gràce a la fonction GetUser du module Shared
        $user = $this->getUser->getUser();
        
        //Si c'est un nouveau marker -> enregistrement de l'utilisateur dans createdBy et modifiedBy 
        if ($isNew && $user) {
            $marker->setCreatedBy($user);
            $marker->setModifiedBy($user);
        }
        //Si ce n'est qu'une modification -> enregistrement de l'utilisateur  dans modifiedBy
        if ($user) {
            $marker->setModifiedBy($user);
        }
        // On enregistre ou met à jour le Marker par le repository (ou plutot son interface)
        $this->markerRepository->saveMarker($marker);
    }
}
