<?php

namespace App\Alert\Application\Mapper;

use App\Alert\Domain\Entity\Alert;
use App\Alert\Application\DTO\AlertDTO;

/**
 * Convertit AlertDTO en entité Alert (et l'inverse)
 * 
 * Nécessaire pour créer ou mettre à jour l'entité avec les données
 */

 class AlertMapper
 {
    public function toEntity(AlertDTO $dto, ?Alert $alert = null): Alert
    {
        if (!$alert) {
            $alert = new Alert();
        }

        if ($dto->message1 !== null) {
            $alert->setMessage1($dto->message1);
        }
        
        if ($dto->message2 !== null) {
            $alert->setMessage2($dto->message2);
        }
       

        return $alert;
    }

    public function toDTO(?Alert $alert): AlertDTO
    {
        $dto = new AlertDTO();
        $dto->message1 = $alert->getMessage1();
        $dto->message2 = $alert->getMessage2();

        return $dto;
    }
    
 }