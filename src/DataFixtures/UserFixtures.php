<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface     //on implémente le fixtureGroupInterface pour pouvoir charger uniquement  CES fixtures (voir GET Group en dessous)
{
    //injection du service qui permet de hasher le password
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    //création de deux utilisateur admin
    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setEmail('arndelp@yahoo.fr');
        $admin1->setPassword($this->hasher->hashPassword($admin1,'Monmotdepasseliveevents2306%'));      //hashage du password admin
        $admin1->setRoles(['ROLE_ADMIN']);

        $admin2 = new User();
        $admin2->setEmail('arndelp595@gmail.com');
        $admin2->setPassword($this->hasher->hashPassword($admin2,'Monmotdepasseliveevents2306%'));
        $admin2->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin1);
        $manager->persist($admin2);


        for ($i=1; $i<=5;$i++){
            $user = new User();
            $user ->setEmail("user$i@gmail.com");
            $user->setPassword($this->hasher->hashPassword($user,"user"));  //pas besoin d'ajouter de Role pour user, il est ajouté par défaut.
            $manager->persist($user);
        }

        $manager->flush();
    }

    public static function getGroups(): array     //nécessiter de créer un groupe de fixture pour sélectionner ceux que l'on veut exécuter lorsqu'on lancera la commade
    {                                               // symfony console doctrine:fixtures:load --group=user --append
        return ['user'];
    }


}
