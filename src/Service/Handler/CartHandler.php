<?php

namespace App\Service\Handler;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartHandler
{
    public function __construct(
        private readonly OrderLineRepository $lineRepository,
        private readonly OrderRepository $orderRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getCart(User $client): ?Order
    {
        return $this->orderRepository->findOneBy(['client' => $client, 'isComplete' => false]);
    }

    public function addToCart(Article $article, User $client, int $quantity): void
    {
        $currentOrder = $this->getCart($client);
        if (!$currentOrder) {
            $currentOrder = $this->buildOrder($client);
        }
        $orderLine = $this->lineRepository->findOneBy(['article' => $article, 'parentOrder' => $currentOrder]);
        if (!$orderLine) {
            $orderLine = $this->buildOrderLine($article, $currentOrder);
        }
        $orderLine->setQuantity($orderLine->getQuantity() + $quantity);

        $this->entityManager->persist($orderLine);
        if (0 == $orderLine->getQuantity()) {
            $currentOrder->removeOrderLine($orderLine);
            $this->entityManager->remove($orderLine);
        }

        $this->entityManager->persist($currentOrder);
        if (0 == count($currentOrder->getOrderLines())) {
            $this->entityManager->remove($currentOrder);
        }

        $this->entityManager->flush();
    }

    private function buildOrder(User $client): Order
    {
        $order = new Order();
        $order->setClient($client);
        $order->setIsComplete(false);
        $order->setCreationDate(new \DateTime());
        $this->entityManager->persist($order);

        return $order;
    }

    private function buildOrderLine(Article $article, Order $parentOrder): OrderLine
    {
        $orderLine = new OrderLine();
        $orderLine->setArticle($article);
        $orderLine->setQuantity(0);
        $parentOrder->addOrderLine($orderLine);
        $this->entityManager->persist($orderLine);
        $this->entityManager->persist($parentOrder);

        return $orderLine;
    }

    public function emptyCart(User $client): void
    {
        $cart = $this->getCart($client);
        if ($cart) {
            $this->entityManager->remove($cart);
            $this->entityManager->flush();
        }
    }

    public function validateCart(User $client): void
    {
        $cart = $this->getCart($client);
        $cart->setIsComplete(true);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}
