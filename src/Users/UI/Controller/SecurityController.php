<?php

namespace App\Users\UI\Controller;


use App\Users\Application\UseCase\Login;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\Application\Service\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
  
    public function login(Login $loginUseCase): Response
    {
        // Si déjà connecté, redirection
        if ($this->getUser()) {
            return $this->redirectToRoute('concert.list.alls'); // ou ta route d’accueil
        }

          // Exécution du Use Case
        $loginResponse = $loginUseCase->execute();

        return $this->render('@User/login.html.twig', [
            'last_username' => $loginResponse->email,
            'error' => $loginResponse->error,
        ]);
    }

    
    public function logout(): void
    {
        throw new \LogicException('Logout is handled by Symfony firewall.');
    }
}

