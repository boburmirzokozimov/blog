<?php

namespace App\Model\User\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class SignUpConfirmTokenSender
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $first, string $last, string $email, string $token): void
    {
        $email = (new TemplatedEmail())
            ->from('boburmirzo@example.com')
            ->to($email)
            ->subject('Confirm your Email')
            ->htmlTemplate('emails/signup.html.twig')
            ->context([
                'token' => $token,
                'name' => $first . ' ' . $last
            ]);

        $this->mailer->send($email);
    }
}