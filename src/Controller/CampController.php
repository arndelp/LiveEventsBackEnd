<?php
declare(strict_types=1);
namespace App\Controller;

use App\Document\Camp;
use Psr\Log\LoggerInterface;
use App\Form\Type\CampType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;









//préfixe de route
#[Route('/camp')]

class CampController extends AbstractController
{
    #[Route('/alls', name: 'camp.list.alls')]
    public function indexAlls(DocumentManager $dm): Response
    {
        $repository = $dm -> getRepository(Camp::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $camps = $repository->findAll([]);
       
       

        return $this->render('camp/index.html.twig', [
            'camps' => $camps, 
           
        ]);
    }

    #[Route('/edit/{id?0}', name: 'camp.edit', methods: ['GET', 'POST'])]
    
    public function editCamp(Camp $camp = null, DocumentManager $dm, Request $request, SluggerInterface $slugger): Response
    {
        //var_dump($marker);
        // initialisation de $new pour les messages futur
        $new = false;  

        // si le marker n'existe pas
        if (!$camp) {
        $new = true;
        
        $camp = new Camp();   // si $new=true, création d'un nouvelle objet
        
        } 
        
        $form = $this->createForm(CampType::class, $camp);

        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
            
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            
            $dm ->persist($camp);
            
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
            
            $this->redirectToRoute('camp.list.alls');
            
            //Si non,
        } else {
            //On affiche le formulaire            


        return $this->render('camp/edit.html.twig', [
            'form' => $form->createView()
        ]);
        }
    }


    #[Route('/delete/{id}', name: 'camp.delete', methods:['GET'])]
    public function deleteBar(Bar $camp, DocumentManager $dm)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si la personne existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($camp) {
            
            $dm->remove($camp);   //ajoute la fonction de suppression dans la transaction
            $dm->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Le POI a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "POI innexistant");

        }
        return $this->redirectToRoute('camp.list.alls');
    }

}
