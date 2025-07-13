<?php
namespace App\Concerts\Infrastructure\Repository;

use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use App\Concerts\Domain\Repository\EventRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class EventRepository extends ServiceEntityRepository implements EventRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Récupérer les jours uniques où des événements sont programmés.
     */
    public function findUniqueEventDays(): array
    {
        // DQL pour récupérer les jours uniques (jour de la semaine)
        $qb = $this->createQueryBuilder('e')
            ->select('DISTINCT e.eventDate')
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery();
        
        $result = $qb->getResult();
        
        // Mapper les numéros de jours (1 = 09/07/2027, 2 = 10/07/2027...) à des noms de jours
        return array_map(function($row) {
        return $row['eventDate']->format('d/m/Y');  // L'événement est déjà sous forme de chaîne, donc pas besoin de formater
    }, $result);
    }

    /**
     * Filtrer les événements en fonction du jour de la semaine.
     */
    public function findEventsByDay(string $day): array
    {
        // Assurez-vous que la date est dans le bon format (si nécessaire, vous pouvez aussi vérifier la validité de la date)
    $formattedDay = \DateTime::createFromFormat('d/m/Y', $day);

    if (!$formattedDay) {
        throw new \InvalidArgumentException("Jour de la semaine invalide.");
    }

    // Convertir la date au format attendu (par exemple '09/07/2027')
    $formattedDayString = $formattedDay->format('Y-m-d');

    // Requête pour récupérer les événements correspondant à une date spécifique (en chaîne)
    return $this->createQueryBuilder('e')
        ->where('e.eventDate = :day')
        ->setParameter('day', $formattedDayString)  // Utiliser la date formatée
        ->getQuery()
        ->getResult();
    }
}
