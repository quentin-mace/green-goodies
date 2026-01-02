<?php

namespace App\Service\Handler;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Gestionnaire de panier d'achat.
 *
 * Ce service gère toutes les opérations liées au panier d'achat d'un utilisateur :
 * récupération, ajout d'articles, vidage et validation. Il interagit avec les
 * entités Order et OrderLine pour maintenir l'état du panier.
 */
class CartHandler
{
    /**
     * Construit une nouvelle instance du gestionnaire de panier.
     *
     * Initialise les dépendances nécessaires pour gérer les commandes et les lignes de commande.
     */
    public function __construct(
        private readonly OrderLineRepository $lineRepository,
        private readonly OrderRepository $orderRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Récupère le panier actif (non complété) d'un client.
     *
     * @return Order|null La commande correspondant au panier, ou null si aucun panier n'existe
     */
    public function getCart(User $client): ?Order
    {
        return $this->orderRepository->findOneBy(['client' => $client, 'isComplete' => false]);
    }

    /**
     * Ajoute un article au panier avec la quantité spécifiée.
     *
     * Si le panier n'existe pas, il est créé automatiquement. Si l'article est déjà
     * présent dans le panier, sa quantité est mise à jour. Si la quantité devient
     * nulle, la ligne de commande est supprimée. Si le panier devient vide, il est
     * également supprimé.
     */
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

    /**
     * Construit une nouvelle commande (panier) pour un client.
     *
     * Crée une nouvelle commande avec le client spécifié, la marque comme incomplète
     * et définit la date de création à maintenant. La commande est persistée en base.
     *
     * @return Order La nouvelle commande créée
     */
    private function buildOrder(User $client): Order
    {
        $order = new Order();
        $order->setClient($client);
        $order->setIsComplete(false);
        $order->setCreationDate(new \DateTime());
        $this->entityManager->persist($order);

        return $order;
    }

    /**
     * Construit une nouvelle ligne de commande pour un article.
     *
     * Crée une nouvelle ligne de commande associée à l'article et à la commande
     * parente. La quantité est initialisée à 0. La ligne et la commande parente
     * sont persistées en base.
     *
     * @return OrderLine La nouvelle ligne de commande créée
     */
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

    /**
     * Vide le panier d'un client en supprimant la commande associée.
     *
     * Récupère le panier actif du client et le supprime s'il existe, ainsi que
     * toutes ses lignes de commande associées.
     */
    public function emptyCart(User $client): void
    {
        $cart = $this->getCart($client);
        if ($cart) {
            $this->entityManager->remove($cart);
            $this->entityManager->flush();
        }
    }

    /**
     * Valide le panier d'un client en le marquant comme complété.
     *
     * Récupère le panier actif du client et le marque comme complété (isComplete = true),
     * transformant ainsi le panier en commande validée.
     */
    public function validateCart(User $client): void
    {
        $cart = $this->getCart($client);
        $cart->setIsComplete(true);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}
