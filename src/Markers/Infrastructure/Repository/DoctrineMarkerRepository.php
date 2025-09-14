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

        // ----------- Comptage total avant pagination -----------
        $countQb = clone $query;               // on clone $query pour séparer le comptage des marker et la récupération des résultats
        $total = (int) $countQb ->select('COUNT(m.id)')
                                ->getQuery()
                                ->getSingleScalarResult(); 
        
        // ----------- Pagination -----------
        $query  ->orderBy('m.type', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);

        $markers = $query->getQuery()->getResult();

        return [
            'markers'   => $markers,
            'total'     => $total,
            'nbrePage'  => (int) ceil($total / $limit),
            'currentPage' => $page
        ];
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
    

