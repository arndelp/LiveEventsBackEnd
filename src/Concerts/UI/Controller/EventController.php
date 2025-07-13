<?php

namespace App\Concerts\UI\Controller;

use App\Concerts\Domain\Repository\EventRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    private $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Afficher les événements et le formulaire de filtrage par jour.
     * 
     * @Route("/events", name="event_index")
     */
    public function listConcerts(Request $request): Response
    {
        // Récupérer les jours uniques des événements
        $availableDays = $this->eventRepository->findUniqueEventDays();

        // Récupérer le jour sélectionné dans le formulaire
        $selectedDay = $request->query->get('concert_day', '');  // Si aucune valeur n'est sélectionnée, par défaut c'est vide

        // Si un jour est sélectionné, filtrer les concerts en fonction du jour
        if ($selectedDay) {
            $concerts = $this->eventRepository->findEventsByDay($selectedDay);
        } else {
            // Sinon, récupérer tous les concerts
            $concerts = $this->eventRepository->findAll();
        }

        // Passer "availableDays" et "concerts" à la vue
        return $this->render('@Concert/event/index.html.twig', [
            'availableDays' => $availableDays,  // Les jours disponibles
            'concerts' => $concerts,  // Les concerts filtrés ou non
        ]);
    }
}
