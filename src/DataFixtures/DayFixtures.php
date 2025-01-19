<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Day;

class DayFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "09/07/2027",
            "10/07/2027",
            "11/07/2027"            
        ];
        for ($i=0; $i<count($data); $i++) {
            $day = new Day(); 
            $day->setDay($data[$i]);
            $manager->persist($day);
        }            
        $manager->flush();
    }
}
