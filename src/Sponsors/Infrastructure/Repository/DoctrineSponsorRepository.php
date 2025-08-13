<?php

namespace App\Sponsors\Infrastructure\Repository;

use App\Sponsors\Domain\Entity\Sponsor;
use Doctrine\Persistence\ManagerRegistry;
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

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->findBy([], ['name' => 'ASC'], $limit, $offset);
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
}
