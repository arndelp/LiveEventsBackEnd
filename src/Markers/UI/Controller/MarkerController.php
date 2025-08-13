<?php
namespace App\Markers\UI\Controller;



use App\Markers\UI\Form\MarkerType;
use App\Markers\Domain\Entity\Marker;
use Doctrine\ORM\EntityManagerInterface;
use App\Markers\Application\DTO\MarkerDTO;
use Symfony\Component\HttpFoundation\Request;
use App\Markers\Application\UseCase\GetMarker;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Markers\Application\UseCase\SaveMarker;
use App\Markers\Application\Mapper\MarkerMapper;
use App\Markers\Application\UseCase\DeleteMarker;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Markers\Application\UseCase\GetPaginatedMarkers;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Markers\Application\UseCase\GetFilteredMarkers;
use App\Markers\Application\DTO\MarkerFilterDTO;
use App\Markers\UI\Form\MarkerFilterType;



class MarkerController extends AbstractController
{
    //constructeur pour injecter le repository (utile pour delete)
    private MarkerRepositoryInterface $markerRepository;

    public function __construct(MarkerRepositoryInterface $markerRepository)
    {
        $this->markerRepository = $markerRepository;
    }


    //liste de tout les markers filtrés

    public function indexFiltered(Request $request, GetFilteredMarkers $getFilteredMarkers): Response
{
    $page = (int) $request->query->get('page', 1);
    $limit = (int) $request->query->get('limit', 10);

    // Création du formulaire avec méthode GET (pour garder les filtres dans l’URL)
    $form = $this->createForm(MarkerFilterType::class, null, ['method' => 'GET']);
    $form->handleRequest($request);

    $type = null;
    // si le formulaire est soumis et valid
    if ($form->isSubmitted() && $form->isValid()) {
        //on récup_re les données du formulaire
        $data = $form->getData();
        //on met dans $type la donnée type de $data
        $type = $data['type'] ?? null;
    }
   
    //construire le DTO de filtre avec les données
    $filter = new MarkerFilterDTO($type);
    // Appeler le useCase avec le filtre
    $markers = $getFilteredMarkers->execute($filter, $page, $limit);

    $nbrePage = $markers['nbrePage'] ?? 1; // Si pas défini, on met 1 par défaut

    //Rendu de la vue
    return $this->render('@Marker/index.html.twig', [
        'markers' => $markers,
        'isPaginated' => true,
        'nbrePage' =>  $nbrePage,
        'page' => $page,
        'nbre' => $limit,
        'filterForm' => $form->createView(),
        'selectedType' => $type,
    ]);
}
    
    //Recherche des détails pour un seul marker         
        //Méthode  avec le param converter (convertisseur de paramètre)
        public function detail(GetMarker $getMarker, int $id): Response
    {
        $marker = $getMarker->execute($id);

        if (!$marker) {
            $this->addFlash('error', "Le POI n'existe pas");
            return $this->redirectToRoute('marker.list.filtered');
        }

        return $this->render('@Marker/detail.html.twig', ['marker' => $marker]);
    }
       
    
    //ajout/édition d'un marker
   
    public function saveMarker(?Marker $marker ,Request $request, SaveMarker $saveMarker, MarkerMapper $markerMapper): Response 
    {
        $new = false;
         // si le marker n'existe pas création d'un nouvel objet Marker
        if (!$marker) {
            $new = true;
            $dto = new MarkerDTO();
        } else {
            //sinon récupération des données par le mapper 
            $dto = $markerMapper->toDTO($marker);
        }

        //Création du formulaire avec les données de $dto (contenant le marker ou rien)
        $form = $this->createForm(MarkerType::class, $dto);
         //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request (données du formulaire)
        $form->handleRequest($request);

      
        //Est-ce que le formulaire est valid et soumis
        if ($form->isSubmitted() && $form->isValid()) {
           //récupération des données et on les transmet au dto
            $dto = $form->getData();
            //Appel au useCase. On lui passe: le DTO, $new (booleen si c'est une création ou une édition, le nom de l'utilisateur)
            $saveMarker->execute($dto, $new, $this->getUser());
            //Création du Flash message de création d'un nouveau marker / ou de modification du marker
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "Le POI". $message);
            //Redirection vers la liste des markers
            return $this->redirectToRoute('marker.list.filtered');
        } else {
            //Sinon on affiche le formulaire à corriger  (alias pour twig et l'architecture en couche)
            return $this->render('@Marker/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

public function delete(int $id, DeleteMarker $deleteMarker): Response
{
   
    if ($id) {       
        $deleteMarker->execute($id);

        $this->addFlash('success', "Le POI a été supprimé avec succès");
    } else {
        $this->addFlash('error', "POI inexistant");
    }

    return $this->redirectToRoute('marker.list.filtered');
}



}
