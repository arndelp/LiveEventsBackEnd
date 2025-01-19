<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Form\AlertType;
<<<<<<< HEAD
use Doctrine\ORM\EntityManagerInterface;
=======
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



//préfixe de route
#[Route('/alert')]

class AlertController extends AbstractController
{
    
    
<<<<<<< HEAD
    #[Route('/edit/{id?1}', name: 'alert.edit', methods: ['GET', 'POST'])] 
=======
        #[Route('/edit/{id?1}', name: 'alert.edit', methods: ['GET', 'POST'])] 
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763
    public function editAlert(Alert $alert = null, ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response    //$alert=null pour avoir une personne vide par défaut en cas de mauvais id
    {
        $new = false;    // initialisation de $new pour les messages futur
        // si le concert n'existe pas
        if (!$alert) {
        $new = true;
        $alert = new Alert();   // si $new=true, création d'un nouvelle objet

        }

        //$concert est l'image du formulaire 
        $form = $this->createForm(AlertType::class, $alert);
        
        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
        
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            $manager = $doctrine->getManager();
            $manager ->persist($alert);
            //transaction
            $manager->flush();
            // Afficher un message de succès
            
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "l'alerte". $message);
            // Rediriger vers la liste des concerts
<<<<<<< HEAD
            return $this->redirectToRoute('concert.list.alls');
=======
            return $this->redirectToRoute('alert.edit');
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763

            // Si non,
        } else {
            //On affiche le formulaire            
            return $this->render('alert/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
<<<<<<< HEAD



    #[Route('/delete/{id}', name: 'alert.delete', methods:['DELETE'])]
    public function deleteAlert(Alert $alert, EntityManagerInterface $em)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si l'alerte existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($alert) {
            
            $em->remove($alert);   //ajoute la fonction de suppression dans la transaction
            $em->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Les alertes ont été supprimées avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "Pas d'alertes présentes");
            
        }
        return $this->redirectToRoute('concert.list.alls');
    }
=======
>>>>>>> 0244e8754f6088963c0e5f40ee6803e1c3f52763
}
        
      


  




