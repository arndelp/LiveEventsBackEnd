<?php

namespace App\Contact\Infrastructure\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Contact\Domain\Service\MailerServiceInterface;

class SymfonyMailerService implements MailerServiceInterface
{
    public function __construct(
        private  MailerInterface $mailer,   //injection du mailer interface de symfony
        private string $receiverEmail
        ) {}  

    public function send(string $from, string $to, string $subject, string $body): void
    {
        $email = (new Email())
            ->from($from)
            ->to($to ?: $this->receiverEmail)  //fallBach si besoin, si $to est vide on utilise $this->receiverEmail
            ->subject($subject)
            ->text($body);

        $this->mailer->send($email);
    }

  
}
