<?php

namespace App\Customers\UI\Controller;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Customers\Domain\Entity\Customer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use App\Customers\Application\DTO\CustomerDTO;
use Symfony\Component\HttpFoundation\Response;
use App\Customers\Application\UseCase\GetCustomer;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Customers\Application\UseCase\SaveCustomer;
use App\Customers\Application\Mapper\CustomerMapper;
use App\Customers\Application\UseCase\DeleteCustomer;
use App\Customers\Application\UseCase\GetPaginatedCustomer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Customers\Domain\Repository\DoctrineCustomerRepository;
use App\Customers\Infrastructure\Security\EmailVerifierCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class CustomerController extends AbstractController
{
    // -------------------
    // UI : Liste paginée
    // -------------------
    public function indexAlls(Request $request, GetPaginatedCustomer $getPaginatedCustomer): Response
    {
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 10);

        $result = $getPaginatedCustomer->execute($page, $limit);

        return $this->render('@Customer/index.html.twig', [
            'customers' => $result['customers'],
            'isPaginated' => true,
            'nbrePage' => $result['nbrePage'],
            'page' => $result['currentPage'],
            'nbre' => $limit
        ]);
    }

    
    public function detail(GetCustomer $getCustomer, int $id): Response
    {
        $customer = $getCustomer->execute($id);

        if (!$customer) {
            $this->addFlash('error', 'Client inconnu');
            return $this->redirectToRoute('customer.list.alls');
        }

        return $this->render('@Customer/detail.html.twig', ['customer' => $customer]);
    }

  
    public function deleteCustomer(DeleteCustomer $deleteCustomer, GetCustomer $getCustomer, int $id): Response
    {
        $customer = $getCustomer->execute($id);

        if ($customer) {
            $deleteCustomer->execute($id);
            $this->addFlash('success', 'Le compte client a été supprimé avec succès');
        } else {
            $this->addFlash('error', 'Compte inexistant');
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
        style: $data['style'] ?? 'Pop',
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

public function verifyCustomerEmail(Request $request, Customer $customer, EmailVerifierCustomer $emailVerifier): JsonResponse
    {
        if (!$customer) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Utilisateur introuvable.'
            ], 404);
        }
        // Vérification du lien de confirmation
        try {
            $emailVerifier->handleEmailConfirmation($request, $customer);

        // Ici on renvoie l'URL front React pour la redirection
        return new JsonResponse([
            'success' => true,
            'redirect' => 'https://arndelp.github.io/LiveEvents/Login'
        ]);

        } catch (VerifyEmailExceptionInterface $e) {
            return new JsonResponse([
                'success' => false,
                'message' => $e->getReason()
            ], 400);
        }
    }
}