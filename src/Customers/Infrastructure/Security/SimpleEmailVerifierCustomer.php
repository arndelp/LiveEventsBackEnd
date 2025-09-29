<?php

namespace App\Customers\Infrastructure\Security;

use Doctrine\ORM\EntityManagerInterface;
use App\Customers\Domain\Entity\Customer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SimpleEmailVerifierCustomer
{
    public function __construct(
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {}

    public function sendVerificationEmail(Customer $customer): void
    {
        $verifyUrl = "https://concertslives.store/verify/simple?id=" . $customer->getId();

        $email = (new TemplatedEmail())
            ->from('no-reply@concertslives.store')
            ->to($customer->getEmail())
            ->subject('Confirmez votre email')
            ->htmlTemplate('emails/simple_verify.html.twig')
            ->context([
                'verifyUrl' => $verifyUrl
            ]);

        $this->mailer->send($email);
    }

    public function markAsVerified(Customer $customer): void
    {
        $customer->setVerified(true);
        $this->entityManager->flush();
    }
}
