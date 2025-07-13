<?php

namespace App\Concerts\Infrastructure\Repository;

use App\Concerts\Domain\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Concerts\Domain\Repository\ConcertRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineConcertRepository extends ServiceEntityRepository implements ConcertRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)  //Fonction publique __construct (constructeur), qui prend en paramètre un objet ManagerRegistry appelé $registry.
    {
        parent::__construct($registry, Concert::class);    //Appelle le constructeur de la classe parente (ServiceEntityRepository) avec deux arguments : l’objet $registry et la classe Alert.
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->findBy([], ['day' => 'ASC', 'schedule' => 'ASC'], $limit, $offset);
    }

    public function countAll(): int
    {
        return $this->count([]);
    }

    public function findById(int $id): ?Concert
    {
        return $this->find($id);
    }

    
    public function saveConcert(Concert $concert): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($concert);
        $em->flush();
    }

    public function deleteConcert(int $id): void
    {
        $concert = $this->findById($id);

        $em = $this->getEntityManager();
        $em->remove($concert);
        $em->flush();
    }
}
