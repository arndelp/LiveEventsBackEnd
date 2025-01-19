<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;

class MailerService
{
    public function __construct(private MailerInterface $mailer) {}
    public function sendEmail(
        $to = 'arndelp595@gmail.com',    // par défault moi, si l'utilisateur donne son email, le mail s'enverra pour lui
        $content = '<p>See Twig integration for better HTML integration!</p>',
        $subject = 'Time for Symfony Mailer!'
    ): void
    {
        $email = (new Email())
            ->from('arndelp595@gmail.com')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            //->text('Sending emails is fun again!')
            ->html($content);

        $this->mailer->send($email);

        
    }
}