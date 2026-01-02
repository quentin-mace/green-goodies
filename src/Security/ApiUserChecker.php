<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Vérificateur d'utilisateur pour l'API.
 *
 * Ce vérificateur implémente UserCheckerInterface pour contrôler l'accès des
 * utilisateurs à l'API. Il vérifie après l'authentification si l'utilisateur
 * a l'accès API activé, et lève une ApiAccessDisabledException si ce n'est
 * pas le cas.
 *
 * @see ApiAccessDisabledException
 */
class ApiUserChecker implements UserCheckerInterface
{
    /**
     * Vérifie l'utilisateur avant l'authentification.
     *
     * Cette méthode est appelée avant l'authentification de l'utilisateur.
     * Dans cette implémentation, aucune vérification n'est effectuée à ce stade.
     */
    public function checkPreAuth(UserInterface $user): void
    {
    }

    /**
     * Vérifie l'utilisateur après l'authentification.
     *
     * Cette méthode est appelée après l'authentification réussie de l'utilisateur.
     * Elle vérifie si l'utilisateur est une instance de User et si son accès API
     * est activé. Si l'accès API n'est pas activé, une ApiAccessDisabledException
     * est levée.
     *
     * @throws ApiAccessDisabledException Si l'utilisateur n'a pas l'accès API activé
     */
    public function checkPostAuth(UserInterface $user): void
    {
        if ($user instanceof User && !$user->isApiEnabled()) {
            throw new ApiAccessDisabledException('API access is not enabled.');
        }
    }
}
