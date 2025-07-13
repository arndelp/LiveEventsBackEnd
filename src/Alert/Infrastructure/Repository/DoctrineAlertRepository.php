<?php

namespace App\Alert\Infrastructure\Repository;

use App\Alert\Domain\Entity\Alert;
use Doctrine\Persistence\ManagerRegistry;
use App\Alert\Domain\Repository\AlertRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;



class DoctrineAlertRepository extends ServiceEntityRepository implements AlertRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alert::class);
    }

    public function editAlert(Alert $alert): void
    {
        $em = $this->getEntityManager(); //hérité de ServiceEntiyRepository 
        $em->persist($alert);
        $em->flush();
    }

    public function deleteAlert(Alert $alert): void
    {
        $em = $this->getEntityManager();
        $em->remove($alert);
        $em->flush();
    }

    public function findById(int $id): ?Alert
    {
        return $this->find($id); // find : méthode héritée du serviceEntityRepository
    }

   

    


}
