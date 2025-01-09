<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Form\AlertType;
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
    
    
        #[Route('/edit/{id?1}', name: 'alert.edit', methods: ['GET', 'POST'])] 
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
            return $this->redirectToRoute('alert.edit');

            // Si non,
        } else {
            //On affiche le formulaire            
            return $this->render('alert/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
}
        
      


  




