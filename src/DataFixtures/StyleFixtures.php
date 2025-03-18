<?php

namespace App\DataFixtures;

use App\Entity\Style;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class StyleFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Pop",
            "Rock",
            "Electro",
            "Country"
            
        ];
        
        for ($i=0; $i<count($data); $i++) {
            $style = new Style(); 
            $style->setStyle($data[$i]);
            $manager->persist($style);
        }            
        $manager->flush();
    }

    public static function getGroups(): array     //nécessiter de créer un groupe de fixture pour sélectionner ceux que l'on veut exécuter lorsqu'on lancera la commade
    {                                               // symfony console doctrine:fixtures:load --group=type --append
        return ['style'];
    }

   
}
