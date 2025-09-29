<?php

namespace App\Customers\UI\Controller;


use Throwable;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Customers\Application\DTO\CustomerDTO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Customers\Application\UseCase\GetCustomer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Customers\Application\UseCase\SaveCustomer;
use App\Customers\Application\Mapper\CustomerMapper;
use App\Customers\Application\UseCase\DeleteCustomer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Customers\Application\UseCase\GetPaginatedCustomer;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Customers\Infrastructure\Security\EmailVerifierCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Customers\Domain\Repository\EmailDuplicationCheckerInterface;


//Controller qui gère la réception , la suppression des message de customer

class CustomerController extends AbstractController
{
    public function indexAlls(Request $request,GetPaginatedCustomer $getPaginatedCustomer, int $page, int $nbre): Response
    {
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 10);
        
        // Appeler le useCase de filtre
        $result = $getPaginatedCustomer->execute($page, $limit);
       
        return $this->render('@Customer/index.html.twig', [
            'customers' => $result['customers'], 
            'isPaginated' => true,
            'nbrePage' => $result['nbrePage'],
            'page' => $result['currentPage'],
            'nbre' => $limit
        ]);
    }
        
       
    public function detail(GetCustomer $getCustomer, int $id):Response          //initialisation à null
    {

        $customer = $getCustomer->execute($id); //Récupère le customer par son ID

    //si l'id n'existe pas
        if(!$customer){ 
            //message flash
            $this->addFlash(type: 'error', message: "Client inconnu"); //si le customer n'existe pas on affiche le message d'erreur
            return $this->redirectToRoute('customer.list.alls');      // Redirige vers la liste des customers.
        }
    //si l'id existe
        return $this->render('@Customer/detail.html.twig', ['customer' => $customer]);       // Si le customer existe, on l'affiche dans la vue.
    } 


    public function deleteCustomer(DeleteCustomer $deleteCustomer, GetCustomer $getCustomer, int $id): Response     {        
        
        $customer = $getCustomer->execute($id);
        
        // Si le message existe, on le supprime, sinon message inexistant
        if ($customer) {
            //Récupération de l'id et envoi au useCase de suppression
            $deleteCustomer->execute($id);

            $this->addFlash('success', "Le compte client a été supprimé avec succès");
        } else {
            $this->addFlash('error', "Compte inexistant");
           
        }
        return $this->redirectToRoute('customer.list.alls');
    }

   
     // Réception du nouveau client
    public function receiveNewCustomer(
        Request $request,
        LoggerInterface $logger,
        ValidatorInterface $validator,        
        SaveCustomer $saveCustomer,  
          
    ): Response {
    $data = json_decode($request->getContent(), true);
   
    $logger->info('Données reçues', ['data' => $data]);
        
    if (empty($data)) {
        return new JsonResponse(['error' => 'Données reçues vides'], 400);
    }
    
    $dto = new CustomerDTO(
        firstname: $data['firstname'] ?? '',
        lastname: $data['lastname'] ?? '',
        email: $data['email'] ?? '',
        password: $data['password'] ?? '',
        style: $data['style'] ?? '',
        streetnumber: $data['streetnumber'] ?? '',
        street: $data['street'] ?? '',
        postalcode: $data['postalcode'] ?? '',
        city: $data['city'] ?? '',
        country: $data['country'] ?? '',
        phone: $data['phone'] ?? '',
    );

    // Validation du DTO
    $errors = $validator->validate($dto);
    if (count($errors) > 0) {            
        return new JsonResponse(['errors' => 'Validation échouée'], 400);
    }
    try {  

        // On délègue au UseCase
        $customer = $saveCustomer->execute($dto);     

        return new JsonResponse([
            'success' => 'Customer créé avec succès',
            'id' => $customer->getId()
        ], 201);

    } catch (\InvalidArgumentException $e) {
        // Erreurs métier (ex: email déjà utilisé)
        return new JsonResponse(['error' => $e->getMessage()], 400);

    } catch (Throwable $e) {
        //Erreurs serveur
        $logger->error('Erreur en recevant le nouveau client : ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);
        return new JsonResponse(['error' => 'Erreur interne serveur.'], 500);
    }
}

    public function verifyCustomerEmail(
    Request $request,
    EmailVerifierCustomer $emailVerifier,
    DoctrineCustomerRepository $customerRepository
): Response {
    $id = $request->query->get('id');

    if (null === $id) {
        return $this->redirect('https://concertslives.store/LiveEvents/VerificationFailed');
    }

    $customer = $customerRepository->find($id);

    if (!$customer) {
        return $this->redirect('https://arndelp.github.io/LiveEvents/VerificationFailed');
    }

    try {
        $emailVerifier->handleEmailConfirmation($request, $customer);

        // Redirection vers React après succès
        return $this->redirect('https://arndelp.github.io/LiveEvents/Verified');
    } catch (\SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface $e) {
        return $this->redirect('https://arndelp.github.io/LiveEvents/VerificationFailed');
    }
}

}







