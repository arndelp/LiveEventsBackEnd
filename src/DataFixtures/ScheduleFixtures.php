<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\ENtity\Schedule;

class ScheduleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "17:00 - 18:00",
            "17:30 - 18:30",
            "18:00 - 19:00",
            "18:30 - 19:30",
            "19:00 - 20:00",
            "19:30 - 20:30",
            "20:00 - 21:00",
            "20:30 - 21:30",
            "21:00 - 22:00",
            "21:30 - 22:30",
            "22:00 - 23:00",
            "22:30 - 23:30",
            "23:00 - 00:00"            
        ];
        for ($i=0; $i<count($data); $i++) {
            $schedule = new Schedule(); 
            $schedule->setSchedule($data[$i]);
            $manager->persist($schedule);
        }            
        $manager->flush();
    }
}
