<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controller gérant l'authentification des utilisateurs.
 *
 * Ce controller gère la connexion et la déconnexion des utilisateurs.
 */
class SecurityController extends AbstractController
{
    /**
     * Affiche le formulaire de connexion et gère l'authentification.
     *
     * @return Response Page de connexion
     */
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * Gère la déconnexion de l'utilisateur.
     *
     * Cette méthode ne sera jamais exécutée car elle est interceptée
     * par la configuration du firewall Symfony.
     *
     * @return void
     */
    #[Route(path: '/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
