<?php
namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
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
#[Route('/concert')]

class ConcertController extends AbstractController
{
     //Recherche avec la méthode findBy() 
     //{page?1} = par défaut page 1
     //{nbre?12}= 12 éléments maxi par page par défault
    #[Route('/alls/{page?1}/{nbre?10}', name: 'concert.list.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response
    {
        $repository = $doctrine -> getRepository(persistentObject: Concert::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $concerts = $repository->findBy([], [], limit: $nbre, offset: ($page - 1)*10);
        // offset: élément à partir duquel on veut avoir les enregistrements
         //page = 1 & nbre = 10 =>offset= 0
         //page = 2 & nbre = 10 => offset = 10
         // page = 3 & nbre = 10 => offset = 20

         //Calcul du nombre de page pour la pagination
        $nbPersonne = $repository->count([]);
        $nbrePage = ceil($nbPersonne / $nbre);    //ceil = arrondi supérieur 

        return $this->render('concert/index.html.twig', [
            'concerts' => $concerts, 
            'isPaginated' => true,
            'nbrePage' => $nbrePage ,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }

    
    //Recherche des détails pour un seul concert
    // <\d+ = requirement entier positif  
    #[Route('/{id<\d+>}', name: 'concert.detail')]
        
        //Méthode  avec le param converter (convertisseur de paramètre)
        public function detail(Concert $concert = null):Response          //initialisation à null
        {
        //si l'id n'existe pas
        if(!$concert){ 
            //message flash
            $this->addFlash(type: 'error', message: "L'évènement n'existe pas");
            return $this->redirectToRoute('concert.list.alls');
        }
        //si l'id existe
                return $this->render('concert/detail.html.twig', ['concert' => $concert]);
    } 
    //ajout/édition d'un évènement
    #[Route('/edit/{id?1}', name: 'concert.edit', methods: ['GET', 'POST'])] // {id?0}: Si l'id n'est pas stipulé, le formulaire sera vide pour ajouter une nouvel évènement
    public function editConcert(Concert $concert = null, ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response    //$concert=null pour avoir une personne vide par défaut en cas de mauvais id
    {
        $new = false;    // initialisation de $new pour les messages futur
        // si le concert n'existe pas
        if (!$concert) {
        $new = true;
        $concert = new Concert();   // si $new=true, création d'un nouvelle objet

        }

        //$concert est l'image du formulaire 
        $form = $this->createForm(ConcertType::class, $concert);
        
        $form->handleRequest($request);   //méthode handleRequest() permet de récupérer toute les info contenu dans l'objet $request
        
        // Est-ce que le formulaire a été soumis?
        if($form->isSubmitted()  && $form->isValid()) { 

        // Si oui, 
            // on va ajouter l'objet  dans la base de données
            $manager = $doctrine->getManager();
            $manager ->persist($concert);
            //transaction
            $manager->flush();
            // Afficher un message de succès
            
            if($new) {
                $message = " a été ajouté avec succès";
            } else {
                $message = " a été mis à jour avec succès";
            }
            $this->addFlash(type: 'success', message: $concert->getName(). $message);
            // Rediriger vers la liste des concerts
            return $this->redirectToRoute('concert.list.alls');

            // Si non,
        } else {
            //On affiche le formulaire            
            return $this->render('concert/edit-concert.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/delete/{id}', name: 'concert.delete', methods:['DELETE'])]
    public function deleteConcert(Concert $concert, EntityManagerInterface $em)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si la personne existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($concert) {
            
            $em->remove($concert);   //ajoute la fonction de suppression dans la transaction
            $em->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "L'évènement a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "Evènement innexistant");

        }
        return $this->redirectToRoute('concert.list.alls');
    }



}
