<?php

namespace App\Sponsors\Application\UseCase;

use App\Sponsors\Domain\Entity\Sponsor;
use App\Sponsors\Application\DTO\SponsorDTO;
use App\Sponsors\Application\Mapper\SponsorMapper;
use App\Shared\Domain\Security\GetUserInterface;  //et non pas userInterface comme en MCV
use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;

/**Logique métier de création/ou modification d'un Sponsor */

class SaveSponsor
{
    //constructeur avec l'injection de la dépendance SponsorRepositoryInterface (une interface de repository pour ne pas dépendre de doctrine)
    public function __construct(private SponsorRepositoryInterface $sponsorRepository,private GetUserInterface $getUser, private SponsorMapper $sponsorMapper) {}
    //execute la méthose appelée par le contrôleur (avec les donné du sponsor (via $dto), la valeur de $new, les donnée de l'utilisateur qui à créé / modifié)
    public function execute(SponsorDTO $dto, bool $isNew): void
    {
        //Convertion du dto vers l'entité (via le mapper)
        $sponsor = $this->sponsorMapper->toEntity($dto, $this->sponsorRepository);
        
        // Récupération du l'utilisateur  de l'instance gràce a la fonction GetUser du module Shared
        $user = $this->getUser->getUser();
        
        //Si c'est un nouveau sponsor -> enregistrement de l'utilisateur dans createdBy et modifiedBy 
        if ($isNew && $user) {
            $sponsor->setCreatedBy($user);
            
        }
        
        // On enregistre ou met à jour le Sponsor par le repository (ou plutot son interface)
        $this->sponsorRepository->saveSponsor($sponsor);
    }
}
