<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Location;


class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Scène CHÂTEAU",
            "Scène GWERNIG",
            "Scène GLENMOR",
            "Scène KEROUAC",
            "Scène GRALL"
        ];
        for ($i=0; $i<count($data); $i++) {
            $location = new Location(); 
            $location->setLocation($data[$i]);
            $manager->persist($location);
        }            
        $manager->flush();
    }
}

 