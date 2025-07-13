<?php

namespace App\Concerts\Application\UseCase;

use App\Concerts\Domain\Entity\Concert;
use App\Concerts\Application\DTO\ConcertDTO;
use App\Shared\Domain\Security\GetUserInterface;  //et non pas userInterface comme en MCV
use App\Concerts\Application\Mapper\ConcertMapper;
use App\Concerts\Domain\Repository\ConcertRepositoryInterface;

/**Logique métier de création/ou modification d'un concert */

class SaveConcert
{
   
    //constructeur avec l'injection de la dépendance ConcertRepositoryInterface (une interface de repository pour ne pas dépendre de doctrine)
    //Injection de la classe GetUser du module Shared
    public function __construct(private ConcertRepositoryInterface $concertRepository,private GetUserInterface $getUser, private ConcertMapper $concertMapper) {}
    //execute la méthose appelée par le contrôleur (avec les donné du concert (via $dto), la valeur de $new, les donnée de l'utilisateur qui à créé / modifié)
    public function execute(ConcertDTO $dto, bool $isNew): void
    {
      
        //Convertion du dto vers l'entité (via le mapper)
        $concert = $this->concertMapper->toEntity($dto, $this->concertRepository);
        // Récupération du l'utilisateur  de l'instance gràce a la fonction GetUser de l"entité Shared
        $user = $this->getUser->getUser();
        

        //Si c'est un nouveau concert -> enregistrement de l'utilisateur dans createdBy et modifiedBy 
        if ($isNew && $user) {
            $concert->setCreatedBy($user);
            $concert->setModifiedBy($user);
        }
        //Si ce n'est qu'une modification isNew est false -> enregistrement de l'utilisateur  dans modifiedBy
        if ($user) {
            $concert->setModifiedBy($user);
        }
        // On enregistre ou met à jour le Concert par le repository (ou plutot son interface)
        $this->concertRepository->saveConcert($concert);
    }
}
