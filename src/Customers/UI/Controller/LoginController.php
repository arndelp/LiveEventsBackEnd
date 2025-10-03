<?php

namespace App\Customers\UI\Controller;

use App\Customers\Domain\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager,
    ) {}

   
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Email ou mot de passe manquant'], 400);
        }

        $customer = $this->em->getRepository(Customer::class)->findOneBy(['email' => $email]);

        if (!$customer || !$this->passwordHasher->isPasswordValid($customer, $password)) {
            return new JsonResponse(['error' => 'Identifiants invalides'], 401);
        }

        // Vérification si l'email est confirmé
        if (!$customer->isIsVerified()) {
            return new JsonResponse(['error' => 'Email non vérifié. Veuillez vérifier votre boîte email.'], 403);  //403 Forbidden
        }

        $token = $this->jwtManager->create($customer);

        return new JsonResponse([
            'token' => $token,
            'user' => [
                'id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'firstname' => $customer->getFirstname(),
                'lastname'  => $customer->getLastname(),
                'style' => $customer->getStyle(),
            ],
        ]);
    }
}
