<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use App\Service\Handler\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Controller gérant les fonctionnalités du panier d'achat.
 *
 * Ce controller permet aux utilisateurs authentifiés de :
 * - Consulter leur panier
 * - Vider le panier
 * - Valider le panier (créer une commande)
 * - Confirmer la validation d'une commande
 */
#[Route('/cart', name: 'app_cart')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CartController extends AbstractController
{
    public function __construct(
        private readonly CartHandler $cartHandler,
    ) {
    }

    /**
     * Affiche le panier de l'utilisateur connecté.
     *
     * @return Response Page du panier
     */
    #[Route('', name: '', methods: ['GET'])]
    public function show(): Response
    {
        /* @var User $client */
        $client = $this->getUser();
        $currentOrder = $this->cartHandler->getCart($client);

        return $this->render('cart/index.html.twig', [
            'cart' => $currentOrder,
        ]);
    }

    /**
     * Vide le panier de l'utilisateur connecté.
     *
     * @return Response Redirection vers la page du panier
     */
    #[Route('/empty', name: '_empty', methods: ['POST'])]
    public function emptyCart(): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $this->cartHandler->emptyCart($client);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * Valide le panier de l'utilisateur connecté (crée une commande).
     *
     * @return Response Redirection vers la page de confirmation
     */
    #[Route('/validate', name: '_validate', methods: ['POST'])]
    public function validateCart(): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $this->cartHandler->validateCart($client);

        return $this->redirectToRoute('app_cart_confirm');
    }

    /**
     * Affiche la page de confirmation après validation du panier.
     *
     * @return Response Page de confirmation de commande
     */
    #[Route('/confirm', name: '_confirm', methods: ['GET'])]
    public function confirmValidation(OrderRepository $repository): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $order = $repository->findOneBy(['client' => $client], ['creationDate' => 'DESC']);

        return $this->render('cart/confirm.html.twig', [
            'order' => $order,
        ]);
    }
}
