<?php
namespace App\Markers\UI\Controller;



use App\Markers\UI\Form\MarkerType;
use App\Markers\Domain\Entity\Marker;
use Doctrine\ORM\EntityManagerInterface;
use App\Markers\Application\DTO\MarkerDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Markers\Application\UseCase\SaveMarker;
use App\Markers\Application\Mapper\MarkerMapper;
use App\Markers\Application\UseCase\DeleteMarker;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Markers\Application\UseCase\GetPaginatedMarkers;
use App\Markers\Domain\Repository\MarkerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class MarkerController extends AbstractController
{
    //constructeur pour injecter le repository (utile pour delete)
    private MarkerRepositoryInterface $markerRepository;

    public function __construct(MarkerRepositoryInterface $markerRepository)
    {
        $this->markerRepository = $markerRepository;
    }



    //liste de tout les markers
    public function indexAlls(GetPaginatedMarkers $getPaginatedMarkers, int $page, int $nbre): Response
    {
        $data = $getPaginatedMarkers->execute($page, $nbre);

        return $this->render('@Marker/index.html.twig', [
            'markers' => $data['markers'],
            'isPaginated' => true,
            'nbrePage' => $data['nbrePage'],
            'page' => $page,
            'nbre' => $nbre,
        ]);
    }

    
    //Recherche des détails pour un seul marker         
        //Méthode  avec le param converter (convertisseur de paramètre)
        public function detail(GetMarker $getMarker, int $id): Response
    {
        $marker = $getMarker->execute($id);

        if (!$marker) {
            $this->addFlash('error', "L'évènement n'existe pas");
            return $this->redirectToRoute('marker.list.alls');
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
            $this->addFlash(type: 'success', message: "L'évènement". $message);
            //Redirection vers la liste des markers
            return $this->redirectToRoute('marker.list.alls');
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

    return $this->redirectToRoute('marker.list.alls');
}



}
