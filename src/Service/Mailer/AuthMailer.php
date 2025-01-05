<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class AuthMailer
{
    public function __construct(
        protected MailerInterface $mailer,
        protected RouterInterface $router
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendForgotEmail(User $user): void
    {
        $email = new TemplatedEmail();
        $email->from('contact@streemi.com');
        $email->to($user->getEmail());
        $email->subject('Réinitialisation du mot de passe');
        $email->htmlTemplate('emails/forgot.html.twig');
        $email->context([
            'user' => $user,
            'url' => $this->router->generate('page_reset', ['token' => $user->getResetToken()], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendResetEmail(User $user): void
    {
        $email = new TemplatedEmail();
        $email->subject('Votre mot de passe à bien été modifié !');
        $email->from(new Address('contact@streemi.com', 'Streemi'));
        $email->to($user->getEmail());
        $email->html('reset');

        $this->mailer->send($email);
    }
}
