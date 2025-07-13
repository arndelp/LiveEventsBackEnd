<?php

namespace App\Concerts\Application\Service;

use App\Concerts\Domain\Repository\EventRepositoryInterface;

class EventService
{
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Récupérer tous les jours où des événements existent.
     */
    public function getUniqueEventDays(): array
    {
        return $this->eventRepository->findUniqueEventDays();
    }

    /**
     * Filtrer les événements par jour de la semaine.
     */
    public function getEventsByDay(string $day): array
    {
        return $this->eventRepository->findEventsByDay($day);
    }
}