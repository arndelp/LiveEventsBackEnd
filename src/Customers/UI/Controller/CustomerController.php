<?php

namespace App\Customers\UI\Controller;

use App\Customers\Application\DTO\CustomerDTO;
use App\Customers\Application\UseCase\GetCustomer;
use App\Customers\Application\UseCase\SaveCustomer;
use App\Customers\Application\UseCase\DeleteCustomer;
use App\Customers\Application\UseCase\GetPaginatedCustomer;
use App\Customers\Application\Mapper\CustomerMapper;
use App\Customers\Domain\Repository\DoctrineCustomerRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

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

    // -------------------
    // UI : Détail client
    // -------------------
    public function detail(GetCustomer $getCustomer, int $id): Response
    {
        $customer = $getCustomer->execute($id);

        if (!$customer) {
            $this->addFlash('error', 'Client inconnu');
            return $this->redirectToRoute('customer.list.alls');
        }

        return $this->render('@Customer/detail.html.twig', ['customer' => $customer]);
    }

    // -------------------
    // UI : Supprimer client
    // -------------------
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

    // -------------------
    // API : Création client depuis React
    // -------------------
    public function receiveNewCustomer(
        Request $request,
        LoggerInterface $logger,
        ValidatorInterface $validator,
        SaveCustomer $saveCustomer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

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
            phone: $data['phone'] ?? ''
        );

        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorsArray], 400);
        }

        try {
            $customer = $saveCustomer->execute($dto);

            // Forcer la vérification si on veut éviter le token
            $customer->setVerified(true);
            $saveCustomer->flushCustomer($customer);

            return new JsonResponse([
                'success' => true,
                'message' => 'Client créé et vérifié avec succès',
                'id' => $customer->getId()
            ], 201);
        } catch (\Throwable $e) {
            $logger->error('Erreur en recevant le nouveau client : ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return new JsonResponse(['error' => 'Erreur interne serveur'], 500);
        }
    }

    // -------------------
    // API : Envoi email simple de confirmation
    // -------------------
    public function sendSimpleConfirmationEmail(
        int $id,
        DoctrineCustomerRepository $customerRepository,
        MailerInterface $mailer
    ): JsonResponse {
        $customer = $customerRepository->find($id);

        if (!$customer) {
            return new JsonResponse(['error' => 'Utilisateur introuvable'], 404);
        }

        $url = 'https://concertslives.store/verify/simple/' . $customer->getId();

        $email = (new TemplatedEmail())
            ->from('no-reply@concertslives.store')
            ->to($customer->getEmail())
            ->subject('Confirmez votre e-mail')
            ->html("
                <h1>Bonjour !</h1>
                <p>Cliquez sur ce lien pour confirmer votre e-mail :</p>
                <p><a href='$url'>Confirmer mon e-mail</a></p>
            ");

        $mailer->send($email);

        return new JsonResponse(['success' => true, 'message' => 'E-mail envoyé']);
    }

    // -------------------
    // API : Vérification simple
    // -------------------
    public function simpleVerify(
        int $id,
        DoctrineCustomerRepository $customerRepository,
        EntityManagerInterface $em
    ): Response {
        $customer = $customerRepository->find($id);

        if (!$customer) {
            return new Response('Utilisateur introuvable', 404);
        }

        $customer->setVerified(true);
        $em->flush();

        return $this->redirect('https://arndelp.github.io/LiveEvents/Verified');
    }
}
