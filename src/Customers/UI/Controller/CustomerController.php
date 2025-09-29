<?php

namespace App\Customers\UI\Controller;

use App\Customers\Domain\Repository\DoctrineCustomerRepository;
use App\Customers\Application\UseCase\SaveCustomer;
use App\Customers\Application\DTO\CustomerDTO;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
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

            return new JsonResponse([
                'success' => true,
                'message' => 'Client créé avec succès',
                'id' => $customer->getId()
            ], 201);
        } catch (\Throwable $e) {
            $logger->error('Erreur en recevant le nouveau client : ' . $e->getMessage());
            return new JsonResponse(['error' => 'Erreur interne serveur'], 500);
        }
    }

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
