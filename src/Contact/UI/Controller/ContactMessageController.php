<?php

namespace App\Contact\UI\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Contact\Application\DTO\ContactMessageInput;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Contact\Application\UseCase\SendContactMessage;
use Psr\Log\LoggerInterface;
use Throwable;

//Controller pou gérer l'envoie d'email 
class ContactMessageController
{
    private SendContactMessage $sendContactMessage;
    private ValidatorInterface $validator;
    private LoggerInterface $logger;
//Constructeur pour injecter les dépendances
    public function __construct(
        SendContactMessage $sendContactMessage,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        //Instanciation des classes
        $this->sendContactMessage = $sendContactMessage;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @Route("/contact-message", name="contact_message", methods={"POST"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Récupérer les données de la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données sont présentes
        if (empty($data)) {
            return new JsonResponse(['error' => 'Données invalides'], 400);
        }

        try {
            // Création du DTO avec les données récupérées de la requête
            $dto = new ContactMessageInput(
                firstname: $data['firstname'] ?? '',
                lastname: $data['lastname'] ?? '',
                email: $data['email'] ?? '',
                message: $data['message'] ?? ''
            );

            // Valide le DTO. Si des erreurs sont trouvées, elles sont renvoyées sous forme de message JSON.
            $errors = $this->validator->validate($dto);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()] = $error->getMessage();
                }
                return new JsonResponse(['errors' => $errorMessages], 400);
            }

            // Si tout est valide, le cas d'utilisation pour envoyer le message est appelé.
            $this->sendContactMessage->execute($dto);
            // Retourne une réponse JSON indiquant que l'envoi a réussi.
            return new JsonResponse([
                'success' => true,
                'message' => 'Message envoyé avec succès'
            ]);
        } catch (Throwable $e) { // En cas d'exception ou d'erreur, on attrape toutes les exceptions via Throwable.
            // Log l'erreur pour le suivi dans les logs.
            $this->logger->error('Erreur lors de l\'envoi du message : ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return new JsonResponse(['error' => 'Erreur interne serveur.'], 500);
        }
    }
}
