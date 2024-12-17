<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    //injection du service qui permet de hasher le password
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    //création de deux utilisateur admin
    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setUsername('admin1');
        $admin1->setPassword($this->hasher->hashPassword($admin1,'admin'));      //hashage du password admin
        $admin1->setRoles(['ROLE_ADMIN']);

        $admin2 = new User();
        $admin2->setUsername('admin2');
        $admin2->setPassword($this->hasher->hashPassword($admin2,'admin'));
        $admin2->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin1);
        $manager->persist($admin2);


        for ($i=1; $i<=5;$i++){
            $user = new User();
            $user ->setUsername("user$i");
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
