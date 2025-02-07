<?php
declare(strict_types=1);
namespace App\Controller;

use App\Document\Bar;
use Psr\Log\LoggerInterface;
use App\Form\Type\BarType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;









//préfixe de route
#[Route('/bar')]

class BarController extends AbstractController
{
    #[Route('/alls', name: 'bar.list.alls')]
    public function indexAlls(DocumentManager $dm): Response
    {
        $repository = $dm -> getRepository(Bar::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $bars = $repository->findAll([]);
       
       

        return $this->render('bar/index.html.twig', [
            'bars' => $bars, 
           
        ]);
    }

    #[Route('/edit/{id?0}', name: 'bar.edit', methods: ['GET', 'POST'])]
    
    public function editBar(Bar $bar = null, DocumentManager $dm, Request $request, SluggerInterface $slugger): Response
    {
        //var_dump($marker);
        // initialisation de $new pour les messages futur
        $new = false;  

        // si le marker n'existe pas
        if (!$bar) {
        $new = true;
        
        $bar = new Bar();   // si $new=true, création d'un nouvelle objet
        
        } 
        
        $form = $this->createForm(BarType::class, $bar);

        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
            
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            
            $dm ->persist($bar);
            
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
            
            $this->redirectToRoute('bar.list.alls');
            
            //Si non,
        } else {
            //On affiche le formulaire            


        return $this->render('bar/edit.html.twig', [
            'form' => $form->createView()
        ]);
        }
    }


    #[Route('/delete/{id}', name: 'bar.delete', methods:['GET'])]
    public function deleteBar(Bar $bar, DocumentManager $dm)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si la personne existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($bar) {
            
            $dm->remove($bar);   //ajoute la fonction de suppression dans la transaction
            $dm->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Le POI a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "POI innexistant");

        }
        return $this->redirectToRoute('bar.list.alls');
    }

}
