<?php
namespace App\Contact\Application\UseCase;


use Throwable;
use InvalidArgumentException;
use App\Contact\Application\DTO\ContactMessageInput;
use App\Contact\Application\UseCase\SetContactMessage;
use App\Contact\Domain\Service\MailerServiceInterface;

class SendContactMessage
{
    public function __construct(
        private MailerServiceInterface $mailer,
        private SetContactMessage $setContactMessage,
        private string $toEmail
    ) {}

    public function execute(ContactMessageInput $input): void
    {
        var_dump('SendContactMessage input email:', $input->email);
        if (empty($input->message) || empty($input->email)) {
            throw new InvalidArgumentException("Message ou email vide");
        }

        // Enregistrer dans la base
        $this->setContactMessage->execute($input);

        // Envoyer l'e-mail
        $subject = "Nouveau message de contact";
        $body = <<<TXT
                        Prénom : {$input->firstname}
                        Nom : {$input->lastname}
                        Email : {$input->email}
                        Message : {$input->message}
                    TXT;

        try {
            $this->mailer->send(
                from: 'arndelp595@gmail.com',
                to: $this->toEmail,
                subject: $subject,
                body: $body
            );
        } catch (Throwable $e) {
            throw new \RuntimeException('Erreur lors de l\'envoi du mail : ' . $e->getMessage());
        }
    }
}
