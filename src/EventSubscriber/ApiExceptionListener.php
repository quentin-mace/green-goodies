<?php

namespace App\EventSubscriber;

use App\Security\ApiAccessDisabledException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Listener d'exceptions pour l'API.
 *
 * Ce listener intercepte les exceptions levées lors des requêtes API et transforme
 * les ApiAccessDisabledException en réponses JSON avec un code HTTP 403.
 * Il ne traite que les exceptions de type ApiAccessDisabledException et uniquement
 * pour les requêtes dont le chemin commence par "/api".
 *
 * @see ApiAccessDisabledException
 */
class ApiExceptionListener
{
    /**
     * Gère les exceptions levées lors du traitement des requêtes.
     *
     * Cette méthode est appelée automatiquement par Symfony lors de l'événement
     * kernel.exception. Elle vérifie si l'exception est une ApiAccessDisabledException
     * et si la requête concerne une route API. Si ces conditions sont remplies,
     * elle crée une réponse JSON avec le message d'erreur et un code HTTP 403.
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if (!$exception instanceof ApiAccessDisabledException) {
            return;
        }

        if (!str_starts_with($request->getPathInfo(), '/api')) {
            return;
        }

        $response = new JsonResponse(
            [
                'message' => $exception->getApiMessage(),
            ],
            403
        );

        $event->setResponse($response);
    }
}
