<?php

namespace App\Concerts\Infrastructure\Repository;

use App\Concerts\Domain\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Concerts\Application\DTO\ConcertFilterDTO;
use App\Concerts\Domain\Repository\ConcertRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineConcertRepository extends ServiceEntityRepository implements ConcertRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)  //Fonction publique __construct (constructeur), qui prend en paramètre un objet ManagerRegistry appelé $registry.
    {
        parent::__construct($registry, Concert::class);    //Appelle le constructeur de la classe parente (ServiceEntityRepository) avec deux arguments : l’objet $registry et la classe Alert.
    }

// Vérifier si un concert existe dèjà avec la même date, scène et horaire 
    public function findDuplicateByDateLocationSchedule(string $day, string $location,string $schedule, ?int $excludeId = null): ?bool
    {
    $qb = $this->createQueryBuilder('c')   ///Création d'un queryBuilder avec la table "c"
        ->where('c.day = :day')                 /*  La colonne "day" doit être égale à la valeur passé en paramêtre ":day"
                                                    L’utilisation de :day au lieu d’insérer directement la valeur $filter->day dans la requête a deux avantages :
                                                    Sécurité (prévention des injections SQL)
                                                    Performance (Doctrine prépare la requête une fois et peut la réutiliser avec différentes valeurs)*/      
        ->andWhere('c.location = :location')
        ->andWhere('c.schedule = :schedule')
        ->setParameter('day', $day)
        ->setParameter('location', $location)
        ->setParameter('schedule', $schedule);
        

    // Exclure le concert en cours lors d'une modification pour éviter les faux positif lors d'une modification de concert
    if ($excludeId !== null) {
        $qb->andWhere('c.id != :excludeId')
           ->setParameter('excludeId', $excludeId);
    }


    // Exécution de la requête, on récupère tous les résultats correspondant aux critères
    $results = $qb->getQuery()->getResult();
    // S'il y a au moins un résultat -> doublon détecté
    if (count($results) > 0) {        
        return true;
    } 


    return false;

    }




//récupération des horaires pour filtre dynamique
    public function findDistinctSchedules(): array
    {
        $qb = $this->createQueryBuilder('c') 
            ->select('DISTINCT c.schedule')
            ->orderBy('c.schedule', 'ASC');

        $results = $qb->getQuery()->getArrayResult();

    return array_map(fn($item) => $item['schedule'], $results);
    }
//récupération des jours pour filtre dynamique
    public function findDistinctDays(): array
    {
        $qb = $this->createQueryBuilder('c')
            ->select('DISTINCT c.day')
            ->orderBy('c.day', 'ASC');

        $results = $qb->getQuery()->getArrayResult();

        return array_map(fn($item) => $item['day'], $results);
    }

    public function findByFilters(ConcertFilterDTO $filter, int $page, int $limit): array
        {
            $query = $this -> createQueryBuilder('m');   //Création d'un queryBuilder avec la table "m"

            if ($filter->day) {                        //  Application du filtre si présent
                $query  ->andWhere('m.day = :day')    
                        ->setParameter('day', $filter->day);  
            }
        // Ajout d'une condition WHERE dans la requête, m:alias de la table,  
        /*L’utilisation de :day au lieu   d’insérer directement la valeur $filter->day dans la requête a deux avantages :
        - Sécurité (prévention des injections SQL)
        - Performance (Doctrine prépare la requête une fois et peut la réutiliser avec différentes valeurs)*/      
        //2 paramètres: le nom du paramètre , puis la valeur
            

            if ($filter->schedule) {                       
                $query  ->andWhere('m.schedule = :schedule')                                     
                        ->setParameter('schedule', $filter->schedule);   
        //2 paramètres: le nom du paramètre , puis la valeur                                    
                        
            }

                    // ----------- Comptage total avant pagination -----------
            $countQb = clone $query;
            $total = (int) $countQb->select('COUNT(m.id)')
                                   ->getQuery()
                                   ->getSingleScalarResult();

            // ----------- Pagination -----------
            $query->orderBy('m.day', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

            $concerts = $query->getQuery()->getResult();

            return [
                'concerts'    => $concerts,
                'total'       => $total,
                'nbrePage'    => (int) ceil($total / $limit),
                'currentPage' => $page
            ];
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
