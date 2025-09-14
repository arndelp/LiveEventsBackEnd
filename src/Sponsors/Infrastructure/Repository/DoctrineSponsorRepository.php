<?php

namespace App\Sponsors\Infrastructure\Repository;

use App\Sponsors\Domain\Entity\Sponsor;
use Doctrine\Persistence\ManagerRegistry;
use App\Sponsors\Application\DTO\SponsorFilterDTO;
use App\Sponsors\Domain\Repository\SponsorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Sponsor>
 */
class DoctrineSponsorRepository extends ServiceEntityRepository implements SponsorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sponsor::class);
    }
    

    public function countAll(): int
    {
        return $this->count([]);
    }

    public function findById(int $id): ?Sponsor
    {
        return $this->find($id);
    }

    public function saveSponsor(Sponsor $sponsor): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($sponsor);
        $em->flush();
    }

    public function deleteSponsor(int $id): void
    {
        $sponsor = $this->findById($id);

        $em = $this->getEntityManager();
        $em->remove($sponsor);
        $em->flush();
    }

    public function findByFilters(SponsorFilterDTO $filter, int $page, int $limit): array
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
        $total = (int) $countQb->select('COUNT(m.id)')
                                ->getQuery()
                                ->getSingleScalarResult(); 
        
        // ----------- Pagination -----------
        $query->orderBy('m.type', 'ASC')
        ->setFirstResult(($page - 1) * $limit)
        ->setMaxResults($limit);

        $sponsors = $query->getQuery()->getResult();

        return [
            'sponsors'   => $sponsors,
            'total'     => $total,
            'nbrePage'  => (int) ceil($total / $limit),
            'currentPage' => $page
        ];
    }
}
