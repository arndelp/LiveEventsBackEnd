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
        $offset = ($page - 1) * $limit;

        return $this->findBy([], [], $limit, $offset);
    }

     public function save(Contact $contact): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($contact);
        $em->flush();
    }
}
