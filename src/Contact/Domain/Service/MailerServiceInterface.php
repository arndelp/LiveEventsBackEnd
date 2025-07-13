<?php

namespace App\Contact\Domain\Service;

interface MailerServiceInterface
{
    public function send(string $from, string $to, string $subject, string $body): void;
}
