<?php
declare(strict_types=1);
namespace App\Controller;

use App\Document\Door;
use App\Form\Type\DoorType;
use Psr\Log\LoggerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;









//préfixe de route
#[Route('/door')]

class DoorController extends AbstractController
{
    #[Route('/alls', name: 'door.list.alls')]
    public function indexAlls(DocumentManager $dm): Response
    {
        $repository = $dm -> getRepository(Door::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $doors = $repository->findAll([]);
       
       

        return $this->render('door/index.html.twig', [
            'doors' => $doors, 
           
        ]);
    }

    #[Route('/edit/{id?0}', name: 'door.edit', methods: ['GET', 'POST'])]
    
    public function editDoor(Door $door = null, DocumentManager $dm, Request $request, SluggerInterface $slugger): Response
    {
        //var_dump($marker);
        // initialisation de $new pour les messages futur
        $new = false;  

        // si le marker n'existe pas
        if (!$door) {
        $new = true;
        
        $door = new Door();   // si $new=true, création d'un nouvelle objet
        
        } 
        
        $form = $this->createForm(DoorType::class, $door);

        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
            
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            
            $dm ->persist($door);
            
            //transaction
            $dm->flush();
            // Afficher un message de succès
            
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "le POI". $message);
            // Rediriger vers la liste des markers
            return  
            
            $this->redirectToRoute('door.list.alls');
            
            //Si non,
        } else {
            //On affiche le formulaire            


        return $this->render('door/edit.html.twig', [
            'form' => $form->createView()
        ]);
        }
    }


    #[Route('/delete/{id}', name: 'door.delete', methods:['GET'])]
    public function deleteDoor(Door $door, DocumentManager $dm)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si la personne existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($door) {
            
            $dm->remove($door);   //ajoute la fonction de suppression dans la transaction
            $dm->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Le POI a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "POI innexistant");

        }
        return $this->redirectToRoute('door.list.alls');
    }

}
