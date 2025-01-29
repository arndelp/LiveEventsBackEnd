<?php
declare(strict_types=1);
namespace App\Controller;


use App\Document\Stage;
use Psr\Log\LoggerInterface;
use App\Form\Type\StageType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//préfixe de route
#[Route('/stage')]

class StageController extends AbstractController
{
    #[Route('/alls', name: 'stage.list.alls')]
    public function indexAlls(DocumentManager $dm): Response
    {
        $repository = $dm -> getRepository(Stage::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $stages = $repository->findAll([]);
       
       

        return $this->render('stage/index.html.twig', [
            'stages' => $stages, 
           
        ]);
    }




    #[Route('/edit/{id?0}', name: 'stage.edit', methods: ['GET', 'POST'])]
    public function editStage(Stage $stage = null, DocumentManager $dm, Request $request, SluggerInterface $slugger): Response
    {
        // initialisation de $new pour les messages futur
        $new = false;  

        // si le marker n'existe pas
        if (!$stage) {
        $new = true;
        
        $stage = new Stage();   // si $new=true, création d'un nouvelle objet

        } 
        
        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
            
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            
            $dm ->persist($stage);
            //transaction
            $dm->flush();
            // Afficher un message de succès
            
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "le POI". $message);
            // Rediriger vers la liste des concerts
            return $this->redirectToRoute('stage.list.alls');

            // Si non,
        } else {
            //On affiche le formulaire            


        return $this->render('stage/edit.html.twig', [
            'form' => $form->createView()
        ]);
        }
    }


    #[Route('/delete/{id}', name: 'stage.delete', methods:['GET'])]
    public function deleteMarker(Stage $stage, DocumentManager $dm)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si la personne existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($stage) {
            
            $dm->remove($stage);   //ajoute la fonction de suppression dans la transaction
            $dm->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Le POI a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "POI innexistant");

        }
        return $this->redirectToRoute('stage.list.alls');
    }



}





















// #[Route('/marker/create', name: 'marker_create', methods: ['GET'])]
// public function browse(DocumentManager $dm)
//     {
//         $marker = new Marker();
//         $marker->setKey("Bar");
//         $marker->setLat(48.6480495744828);
//         $marker->setLng(1.8157557433476355);
//         $marker->setTitle("Bar du château");
//         $marker->setImage("../assets/bars.png");
//         $marker->setWidth("30 em");
//         $marker->setHeight("30 em");
    
//         $dm->persist($marker);
//         $dm->flush();
    
//         return new Response('Created marker id ' . $marker->getId());
//     }
