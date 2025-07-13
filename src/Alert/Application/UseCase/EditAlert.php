<?php

namespace App\Alert\Application\UseCase;

use App\Alert\Domain\Entity\Alert;
use App\Alert\Application\DTO\AlertDTO;
use App\Alert\Application\Mapper\AlertMapper;
use App\Alert\Domain\Repository\AlertRepositoryInterface;


/**Logique métier de création/ou modification d'une alert */

class EditAlert
{
    private AlertRepositoryInterface $alertRepository;
    private AlertMapper $alertMapper;
    //constructeur avec l'injection de la dépendance ConcertRepositoryInterface (une interface de repository pour ne pas dépendre de doctrine)
    public function __construct(AlertRepositoryInterface $alertRepository,AlertMapper $alertMapper ) 
    {
        $this->alertRepository = $alertRepository;
        $this->alertMapper = $alertMapper;
    }

    
    /**
     * AlertDTO $dto Les données de l'alerte (via le contrôleur)
     * bool $new True si c'est une création, False si c'est une modification
     */

    //execute la méthose appelée par le contrôleur (avec les donné du concert (via $dto), la valeur de $new,
    public function execute(AlertDTO $dto, bool $new): void
{
    // Si c'est une création, on crée une nouvelle entité depuis le DTO
    if ($new) {
        $alert = $this->alertMapper-> toEntity($dto);
    } else {
        // Sinon, on va chercher l'entité existante et on la met à jour
        $alert = $this->alertRepository->findById($dto->id);
        if (!$alert) {
            throw new \Exception("Alert not found");
        }

        // On met à jour les propriétés
        $alert->setMessage1($dto->message1);
        $alert->setMessage2($dto->message2);
        // ... ajoute les autres propriétés à mettre à jour
    }

    // On enregistre ou met à jour l'alert via le repository
    $this->alertRepository->editAlert($alert);
}
}


