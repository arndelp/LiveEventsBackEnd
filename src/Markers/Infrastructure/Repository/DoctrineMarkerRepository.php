<?php

namespace App\Markers\Infrastructure\Repository;


use App\Markers\Domain\Entity\Marker;
use Doctrine\Persistence\ManagerRegistry;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Marker>
 */
class DoctrineMarkerRepository extends ServiceEntityRepository implements MarkerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marker::class);  //Appelle le constructeur de la classe parente (ServiceEntityRepository) avec deux arguments : l’objet $registry et la classe Alert.
    }

    public function findPaginated(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->findBy([], ['type' => 'ASC'], $limit, $offset);
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
    

