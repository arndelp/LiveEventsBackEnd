<?php

namespace App\Customers\Infrastructure\Repository;


use Doctrine\ORM\EntityManagerInterface;
use App\Customers\Domain\Entity\Customer;
use App\Customers\Domain\Repository\EmailDuplicationCheckerInterface;

class EmailDuplicationChecker implements EmailDuplicationCheckerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Vérifie si l'email existe déjà dans la base de données
     *
     * @param string $email
     * @return bool
     */
    public function isEmailDuplicate(string $email): bool
    {
        // Chercher un utilisateur avec cet email dans la base de données
        $customerRepository = $this->entityManager->getRepository(Customer::class);
        $customer = $customerRepository->findOneBy(['email' => $email]);

        // Si un utilisateur existe avec cet email, c'est un doublon
        return $customer !== null;
    }
}
