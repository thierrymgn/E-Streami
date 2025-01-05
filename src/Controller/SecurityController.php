<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\Mailer\AuthMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Uid\Uuid;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/forgot', name: 'app_forgot_password')]
    public function forgotPassword(
        Request $request,
        UserRepository $usersRepository,
        EntityManagerInterface $entityManager,
        AuthMailer $authMailer
    ): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $usersRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cet email.');
                return $this->redirectToRoute('app_forgot_password');
            }

            $resetToken = Uuid::v4()->toRfc4122();
            $user->setResetToken($resetToken);
            $entityManager->flush();

            $authMailer->sendForgotEmail($user);

            $this->addFlash('success', 'Un email de réinitialisation a été envoyé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/forgot.html.twig');
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/reset/{token}', name: 'page_reset')]
    public function reset(
        string $token,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        AuthMailer $authMailer
    ): Response
    {
        $user = $userRepository->findOneBy(['resetToken' => $token]);

        if (!$user) {
            $this->addFlash('error', 'Token invalide.');
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $password = $request->get('password');
            $repeatedPassword = $request->get('repeat-password');

            if ($password !== $repeatedPassword) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->render('security/reset.html.twig', ['token' => $token]);
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
            $user->setResetToken(null);
            $authMailer->sendResetEmail($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset.html.twig', [
            'token' => $token,
            'user' => $user
        ]);
    }
}
