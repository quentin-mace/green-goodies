<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(OrderRepository $orderRepository): Response
    {
        $client = $this->getUser();
        $currentOrder = $orderRepository->findOneBy(['client' => $client, 'isComplete' => false]);

        return $this->render('cart/index.html.twig', [
            'cart' => $currentOrder,
        ]);
    }
}
