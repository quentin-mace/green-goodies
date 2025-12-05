<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Handler\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'app_cart')]
final class CartController extends AbstractController
{
    public function __construct(
        private readonly CartHandler $cartHandler,
    ) {
    }

    #[Route('', name: '')]
    public function show(): Response
    {
        /* @var User $client */
        $client = $this->getUser();
        $currentOrder = $this->cartHandler->getCart($client);

        return $this->render('cart/index.html.twig', [
            'cart' => $currentOrder,
        ]);
    }

    #[Route('/empty', name: '_empty')]
    public function emptyCart(): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $this->cartHandler->emptyCart($client);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/validate', name: '_validate')]
    public function validateCart(): Response
    {
        /* @var User $client */
        $client = $this->getUser();

        $this->cartHandler->validateCart($client);

        return $this->redirectToRoute('app_home');
    }
}
