<?php

namespace App\Security;

/**
 * Exception levée lorsque l'accès à l'API est désactivé pour un utilisateur.
 *
 * Cette exception est utilisée pour indiquer qu'un utilisateur tente d'accéder
 * à l'API alors que son accès API n'est pas activé. Elle contient un message
 * spécifique pour l'API qui peut être récupéré via getApiMessage().
 */
class ApiAccessDisabledException extends \Exception
{
    private string $apiMessage;

    /**
     * Construit une nouvelle instance de l'exception.
     *
     * Initialise l'exception avec un message par défaut si aucun n'est fourni
     * et stocke le message pour qu'il puisse être récupéré via getApiMessage().
     */
    public function __construct(string $message = 'API access is not enabled.', ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->apiMessage = $message;
    }

    /**
     * Récupère le message d'erreur spécifique à l'API.
     *
     * @return string Le message d'erreur pour l'API
     */
    public function getApiMessage(): string
    {
        return $this->apiMessage;
    }
}
