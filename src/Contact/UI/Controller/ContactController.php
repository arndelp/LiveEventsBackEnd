<?php

namespace App\Contact\UI\Controller;


use Throwable;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Contact\Application\UseCase\GetContact;
use App\Contact\Application\UseCase\DeleteContact;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Contact\Application\DTO\ContactMessageInput;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Contact\Application\UseCase\SendContactMessage;
use App\Contact\Application\UseCase\SentContactMessage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Contact\Application\UseCase\GetPaginatedContact;
use App\Contact\Application\Mapper\ContactMessageInputMapper;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

//Controller qui gère la réception , la suppression des message de contact

class ContactController extends AbstractController
{
    public function indexAlls(GetPaginatedContact $getPaginatedContact, int $page, int $nbre): Response
    {
        //récupération des data paginées des contact
       $data = $getPaginatedContact->execute($page, $nbre);
        
       
        return $this->render('@Contact/index.html.twig', [
            'contacts' => $data['contacts'], 
            'isPaginated' => true,
            'nbrePage' => $data['contacts'],
            'page' => $page,
            'nbre' => $nbre
        ]);
    }
        
       
    public function detail(GetContact $getContact, int $id):Response          //initialisation à null
    {

        $contact = $getContact->execute($id); //Récupère le contact par son ID

    //si l'id n'existe pas
        if(!$contact){ 
            //message flash
            $this->addFlash(type: 'error', message: "Il n'y a pas de message"); //si le contact n'existe pas on affiche le message d'erreur
            return $this->redirectToRoute('contact.list.filtered');      // Redirige vers la liste des contacts.
        }
    //si l'id existe
        return $this->render('@Contact/detail.html.twig', ['contact' => $contact]);       // Si le contact existe, on l'affiche dans la vue.
    } 


    public function deleteContact(DeleteContact $deleteContact, GetContact $getContact, int $id): Response     {        
        
        $contact = $getContact->execute($id);
        
        // Si le message existe, on le supprime, sinon message inexistant
        if ($contact) {
            //Récupération de l'id et envoi au useCase de suppression
            $deleteContact->execute($id);

            $this->addFlash('success', "Le message a été supprimé avec succès");
        } else {
            $this->addFlash('error', "Message inexistant");
           
        }
        return $this->redirectToRoute('contact.list.filtered');
    }

    // Envoie de mail dès réception d'un message
    public function receiveMessage(Request $request, 
        SendContactMessage $sendContactMessage,  
        LoggerInterface $logger,
        ValidatorInterface $validator,
        ContactMessageInputMapper $mapper
    ): Response
    {
    // Récupération des données JSON envoyées par le front
    $data = json_decode($request->getContent(), true);
    $logger->info('Données reçues', ['data' => $data]);  //log

    if (empty($data)) {
        return new JsonResponse(['error' => 'Données reçues vides'], 400); //si pas de data , retour d'une erreur
    }

    try {
        // Création du DTO
        $dto = new ContactMessageInput(
            firstname: $data['firstname'] ?? '',
            lastname: $data['lastname'] ?? '',
            email: $data['email'] ?? '',
            message: $data['message'] ?? ''
        );

        // Validation du DTO
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => 'Validation échouée'], 400);    // Retourne une erreur si la validation échoue.
        }

        // Mapping DTO en Entité par le mapper
        $entity = $mapper->toEntity($dto);

        // Exécution du UseCase pour envoyer le message
        $sendContactMessage->execute($entity);

        return new JsonResponse([
            'success' => true,
            'message' => 'Message envoyé avec succès'
        ]);
    } catch (Throwable $e) {
        // Si une erreur se produit, on logue l'exception et renvoie une erreur générique.
        $logger->error('Erreur en recevant le message de contact : ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);
        return new JsonResponse(['error' => 'Erreur interne serveur.'], 500);
    }
}





}