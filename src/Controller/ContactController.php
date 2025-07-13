<?php
namespace App\Controller;

use App\Entity\Contact;
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
#[Route('/contact')]

class ContactController extends AbstractController
{
    #[Route('/alls/{page?1}/{nbre?10}', name: 'contact.list.alls')]
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response
    {
        $repository = $doctrine -> getRepository(persistentObject: Contact::class);
        // définition de base de la méthode findBy(): function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)      $limit et $ $offset permettent de faire une pagination
        $contacts = $repository->findBy([], [], limit: $nbre, offset: ($page - 1)*10);
        // offset: élément à partir duquel on veut avoir les enregistrements
         //page = 1 & nbre = 10 =>offset= 0
         //page = 2 & nbre = 10 => offset = 10
         // page = 3 & nbre = 10 => offset = 20

         //Calcul du nombre de page pour la pagination
        $nbMessage = $repository->count([]);
        $nbrePage = ceil($nbMessage / $nbre);    //ceil = arrondi supérieur 

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts, 
            'isPaginated' => true,
            'nbrePage' => $nbrePage ,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }

    #[Route('/{id<\d+>}', name: 'contact.detail')]
        
        //Méthode  avec le param converter (convertisseur de paramètre)
        public function detail(Contact $contact = null):Response          //initialisation à null
        {
        //si l'id n'existe pas
        if(!$contact){ 
            //message flash
            $this->addFlash(type: 'error', message: "Il n'y a pas de message");
            return $this->redirectToRoute('contact.list.alls');
        }
        //si l'id existe
                return $this->render('contact/detail.html.twig', ['contact' => $contact]);
    } 


    #[Route('/delete/{id}', name: 'contact.delete', methods:['DELETE'])]
    public function deleteContact(Contact $contact, EntityManagerInterface $em)     // on doit initialiser "$personne=null"  sinon on a une erreur avec le param concerter
    {        
        // Si la personne existe => le supprimer et retourner un flashMessage de succès                                                                                                 //ManagerRegistry nécessaire pour le remove
        // Récupérer le concert
        if ($contact) {
            
            $em->remove($contact);   //ajoute la fonction de suppression dans la transaction
            $em->flush();   //exécution de la transaction
            $this->addFlash(type: 'success', message: "Le message a été supprimé avec succès");

        } else {
            // Sinon retourner un flashMessage d'erreur
            $this->addFlash(type: 'error', message: "Message innexistant");

        }
        return $this->redirectToRoute('contact.list.alls');
    }



}