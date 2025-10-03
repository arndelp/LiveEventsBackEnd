<?php

namespace App\Customers\Infrastructure\Security;



use Doctrine\ORM\EntityManagerInterface;
use App\Customers\Domain\Entity\Customer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class EmailVerifierCustomer
{
    public function __construct(
        private VerifyEmailHelperInterface $verifyEmailHelper,
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, Customer $customer, TemplatedEmail $email): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $customer->getId(),
            $customer->getEmail(),
            ['id' => $customer->getId()] // important pour reconstruire l'URL
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, Customer $customer): void
    {
        $this->verifyEmailHelper->validateEmailConfirmationFromRequest(
            $request, 
            $customer->getId(), //identifiant de l'utilisateur
            $customer->getEmail(), //email de l'utilisateur   
            
        );

        $customer->setVerified(true);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }
}
