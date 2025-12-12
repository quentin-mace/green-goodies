<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use App\Service\Handler\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/cart', name: 'app_cart')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CartController extends AbstractController
{
    public function __construct(
        private readonly CartHandler $cartHandler,
    ) {
    }

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

    #[Route('/empty', name: '_empty', methods: ['POST'])]
    public function emptyCart(): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $this->cartHandler->emptyCart($client);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/validate', name: '_validate', methods: ['POST'])]
    public function validateCart(): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $this->cartHandler->validateCart($client);

        return $this->redirectToRoute('app_cart_confirm');
    }

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
