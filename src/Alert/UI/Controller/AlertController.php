<?php

namespace App\Alert\UI\Controller;



use App\Alert\UI\Form\AlertType;
use App\Alert\Domain\Entity\Alert;
use App\Alert\Application\DTO\AlertDTO;
use Doctrine\Persistence\ManagerRegistry;
use App\Alert\Application\UseCase\EditAlert;
use Symfony\Component\HttpFoundation\Request;
use App\Alert\Application\Mapper\AlertMapper;
use Symfony\Component\HttpFoundation\Response;
use App\Alert\Application\UseCase\DeleteAlert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





class AlertController extends AbstractController
{
    private AlertMapper $alertMapper;

    public function __construct(AlertMapper $alertMapper)
    {
        $this->alertMapper = $alertMapper;
    }
    
    public function editAlert(EditAlert $editAlert, ManagerRegistry $doctrine, Request $request,  ?Alert $alert = null): Response    //Le ?Alert $alert = null permet de gérer à la fois la création (si $alert est null) et la modification (si $alert est une entité existante).
    {
        $new = false;    // initialisation de $new pour les messages futur
        // si l'alerte n'existe pas
        // DTO à passer au formulaire
        if (!$alert) {
        $new = true;
        $dto = new AlertDTO();   // si $new=true, création d'un nouveau dto vide
        } else {
             $dto = $this->alertMapper->toDTO($alert);  // Convertir l'entité en DTO
        }

        //formulaire avec les données du dto
        $form = $this->createForm(AlertType::class, $dto);
        
        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
        
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

            // transforme le DTO en entité (créée ou existante)
           $alert = $this->alertMapper->toEntity($dto, $alert ?? null);
             // exécute le use case qui va persister l'entité
            $editAlert->execute($dto, $new);

            if($new) {
                $message = " a été activée avec succès";
            } else {
                $message = " a été mise à jour avec succès";
            }
            $this->addFlash(type: 'success', message: "L'alerte". $message);
            // Rediriger vers la liste des concerts
            return $this->redirectToRoute('concert.list.filtered');

            // Si non,
        } else {
            //On affiche le formulaire            
            return $this->render('@Alert/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }



    public function delete(?Alert $alert, DeleteAlert $deleteAlert )    
    {        
        // Si l'alerte existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($alert) {
            $deleteAlert->execute($alert);           
            $this->addFlash('success', message: "L' alerte est maintenant désactivée");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash('error', message: "Pas d'alerte présente");
            
        }
        return $this->redirectToRoute('concert.list.filtered');
    }
}
        
      


  




