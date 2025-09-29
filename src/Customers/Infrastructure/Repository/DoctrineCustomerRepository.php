<?php

namespace App\Customers\Infrastructure\Repository;


use App\Customers\Domain\Entity\Customer;
use Doctrine\Persistence\ManagerRegistry;
use App\Customers\Domain\Repository\CustomerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class DoctrineCustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function deleteCustomer(Customer $customer): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->remove($customer);
        $em->flush();
    }

    public function findById(int $id): ?Customer
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

        return $this->findBy([], ['lastname' => 'ASC'], $limit, $offset);
    }

     public function save(Customer $customer): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($customer);
        $em->flush();
    }
}
