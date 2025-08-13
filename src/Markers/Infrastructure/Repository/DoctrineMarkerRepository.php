<?php

namespace App\Markers\Infrastructure\Repository;


use App\Markers\Domain\Entity\Marker;
use Doctrine\Persistence\ManagerRegistry;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Markers\Application\DTO\MarkerFilterDTO;


/**
 * @extends ServiceEntityRepository<Marker>
 */
class DoctrineMarkerRepository extends ServiceEntityRepository implements MarkerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marker::class);  //Appelle le constructeur de la classe parente (ServiceEntityRepository) avec deux arguments : l’objet $registry et la classe Alert.
    }

    public function findByFilters(MarkerFilterDTO $filter, int $page, int $limit): array
    {
        $query = $this -> createQueryBuilder('m');   //Création d'un queryBuilder avec la table "m"

        if ($filter->type) {                        //  Application du filtre si présent
            $query  ->andWhere('m.type = :type')    // Ajout d'une condition WHERE dans la requête, m:alias de la table,  
                                                    /*L’utilisation de :type au lieu d’insérer directement la valeur $filter->type dans la requête a deux avantages :
                                                        Sécurité (prévention des injections SQL)
                                                        Performance (Doctrine prépare la requête une fois et peut la réutiliser avec différentes valeurs)*/      
                    ->setParameter('type', $filter->type);   //2 paramètres: le nom du paramètre , puis la valeur
        }

        $query  ->orderBy('m.type', 'ASC')          // Application de tri par type(croissant), 
                ->setFirstResult(($page - 1) * $limit)   //puis de l'offset (premier élément)
                ->setMaxResults($limit);       //, puis limite pour la pagination

        return $query->getQuery()->getResult();      // Exécution de la requête et récupération des résultats
    }  

    public function countAll(): int
    {
        return $this->count([]);
    }

    public function findById(int $id): ?Marker
    {
        return $this->find($id);
    }

    public function saveMarker(Marker $marker): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($marker);
        $em->flush();
    }

   public function deleteMarker(int $id): void
    {
        $marker = $this->findById($id);

        $em = $this->getEntityManager();
        $em->remove($marker);
        $em->flush();
    }
}
    

