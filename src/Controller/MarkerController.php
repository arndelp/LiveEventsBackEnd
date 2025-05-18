<?php
namespace App\Controller;

use App\Entity\Marker;
use App\Form\MarkerType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


//préfixe de route
#[Route('/marker')]

class MarkerController extends AbstractController
{
     //Recherche avec la méthode findBy() 
     //{page?1} = par défaut page 1
     //{nbre?12}= 12 éléments maxi par page par défault
    #[Route('/alls/{page?1}/{nbre?10}', name: 'marker.list.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response
    {
        $repository = $doctrine -> getRepository(persistentObject: Marker::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $markers = $repository->findBy(array(), array('type'=>'ASC'), limit: $nbre, offset: ($page - 1)*10);
        // offset: élément à partir duquel on veut avoir les enregistrements
         //page = 1 & nbre = 12 =>offset= 0
         //page = 2 & nbre = 12 => offset = 12
         // page = 3 & nbre = 12 => offset = 24

         //Calcul du nombre de page pour la pagination
        $nbMarker = $repository->count([]);
        $nbrePage = ceil($nbMarker / $nbre);    //ceil = arrondi supérieur 

        return $this->render('marker/index.html.twig', [
            'markers' => $markers, 
            'isPaginated' => true,
            'nbrePage' => $nbrePage ,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }

    
    //Recherche des détails pour un seul marker
    // <\d+ = requirement entier positif  
    #[Route('/{id<\d+>}', name: 'marker.detail')]
        
        //Méthode  avec le param converter (convertisseur de paramètre)
        public function detail(Marker $marker = null):Response          //initialisation à null
        {
        //si l'id n'existe pas
        if(!$marker){ 
            //message flash
            $this->addFlash(type: 'error', message: "Le POI n'existe pas");
            return $this->redirectToRoute('marker.list.alls');
        }
        //si l'id existe
                return $this->render('marker/detail.html.twig', ['marker' => $marker]);
    } 
    //ajout/édition d'un marker
    #[Route('/edit/{id?0}', name: 'marker.edit', methods: ['GET', 'POST'])] // {id?0}: Si l'id n'est pas stipulé, le formulaire sera vide pour ajouter une nouvel évènement
    public function editMarker(Marker $marker = null, ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response    //$concert=null pour avoir une personne vide par défaut en cas de mauvais id
    {
        $new = false;    // initialisation de $new pour les messages futur
        // si le marker n'existe pas
        if (!$marker) {
        $new = true;
        $marker = new Marker();   // si $new=true, création d'un nouvelle objet

        }

        //$marker est l'image du formulaire 
        $form = $this->createForm(MarkerType::class, $marker);
        
        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
        
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            $manager = $doctrine->getManager();
            $manager ->persist($marker);
            //transaction
            $manager->flush();
            // Afficher un message de succès
            
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: $marker->getName(). $message);
            // Rediriger vers la liste des markers
            return $this->redirectToRoute('marker.list.alls');

            // Si non,
        } else {
            //On affiche le formulaire            
            return $this->render('marker/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'marker.delete', methods:['DELETE'])]
    public function deleteMarker(Marker $marker, EntityManagerInterface $em)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si le marker existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le marker
        if ($marker) {
            
            $em->remove($marker);   //ajoute la fonction de suppression dans la transaction
            $em->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Le POI a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "POI innexistant");

        }
        return $this->redirectToRoute('marker.list.alls');
    }



}
