<?php

namespace App\Users\UI\Controller;



use App\Users\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use App\Users\UI\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Users\Application\UseCase\RegisterUser;
use App\Users\Application\DTO\RegisterUserInputDto;
use App\Users\Infrastructure\Security\EmailVerifier;
use App\Users\Domain\Repository\EmailDuplicationCheckerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailDuplicationCheckerInterface $emailDuplicationChecker;
    private EmailVerifier $emailVerifier;
    
    
    public function __construct(EmailVerifier $emailVerifier, EmailDuplicationCheckerInterface $emailDuplicationChecker) 
    {
        $this->emailVerifier = $emailVerifier; 
        $this->emailDuplicationChecker = $emailDuplicationChecker;
    }

    
    public function registerUser(Request $request, RegisterUser $registerUser): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Récupérer les données du formulaire
            $data = $form->getData();
            $email = $data->getEmail();
            

            // Vérification si l'email existe déjà dans la base de données
            if ($this->emailDuplicationChecker->isEmailDuplicate($email)) {
                $this->addFlash('error', 'Cet email est déjà utilisé.');

                return $this->redirectToRoute('app_register');
            }    



 // Si l'email est unique, créer le DTO et exécuter l'enregistrement
            $dto = new RegisterUserInputDto(
                $data->getEmail(),
                $form->get('password')->getData(),
                $data->getFirstname(),
                $data->getLastname(),
            );

            // Appelle le cas d'utilisation pour créer l'utilisateur
            $user = $registerUser->execute($dto);

            // Ajoute un message flash pour indiquer que l'inscription a réussi
            $this->addFlash('success', 'Votre inscription a été réussie !');

             // Redirige vers une page de connexion ou vers une autre page de confirmation
            return $this->redirectToRoute('concert.list.filtered'); 
        }

        return $this->render('@User/register.html.twig', [
            'registrationForm' => $form ->createView(),
        ]);
    }

    
     public function verifyUserEmail(Request $request, EntityManagerInterface $em): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            $this->addFlash('verify_email_error', 'Id utilisateur manquant.');
            return $this->redirectToRoute('app_register');
        }

        $user = $em->getRepository(User::class)->find($id);

        if (null === $user) {
            $this->addFlash('verify_email_error', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_register');
        }

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());
            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse e-mail a bien été vérifiée');

        return $this->redirectToRoute('concert.list.filtered');
    }
}

