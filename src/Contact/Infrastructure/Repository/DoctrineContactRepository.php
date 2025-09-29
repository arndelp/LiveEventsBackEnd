<?php

namespace App\Contact\Infrastructure\Repository;


use App\Contact\Domain\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;
use App\Contact\Domain\Repository\ContactRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class DoctrineContactRepository extends ServiceEntityRepository implements ContactRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function deleteContact(Contact $contact): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->remove($contact);
        $em->flush();
    }

    public function findById(int $id): ?Contact
    {
        return $this->find($id); // find : méthode héritée du serviceEntityRepository
    }

    public function countAll(): int
    {
        return $this->count([]);
    }

    public function findPaginated(int $page,int $limit): array
    {
        $query = $this -> createQueryBuilder('m');

        $countQb = clone $query;               // on clone $query pour séparer le comptage des marker et la récupération des résultats
        $total = (int) $countQb ->select('COUNT(m.id)')
                                ->getQuery()
                                ->getSingleScalarResult(); 
        
        // ----------- Pagination -----------
        $query  ->orderBy('m.id', 'ASC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);

        $contacts = $query->getQuery()->getResult();

        return [
            'contacts'   => $contacts,
            'total'     => $total,
            'nbrePage'  => (int) ceil($total / $limit),
            'currentPage' => $page
        ];
    }

     public function save(Contact $contact): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($contact);
        $em->flush();
    }
}
