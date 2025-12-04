<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_article', requirements: ['id' => "\d+"])]
    public function index(Article $article, Request $request, OrderRepository $orderRepository, OrderLineRepository $lineRepository, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createFormBuilder()
            ->add('quantity', NumberType::class, ['label' => false])
            ->add('save', SubmitType::class, ['label' => 'Ajouter au panier'])
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $form->getData()['quantity'];
            $client = $this->getUser();

            $currentOrder = $orderRepository->findOneBy(['client' => $client, 'isComplete' => false]);
            if(!$currentOrder){
                $currentOrder = new Order();
                $currentOrder->setClient($client);
                $currentOrder->setIsComplete(false);
                $currentOrder->setCreationDate(new DateTime());
            }
            $orderLine = $lineRepository->findOneBy(['article' => $article, 'parentOrder' => $currentOrder]);
            if(!$orderLine){
                $orderLine = new OrderLine();
                $orderLine->setArticle($article);
                $orderLine->setQuantity(0);
                $currentOrder->addOrderLine($orderLine);
            }
            $orderLine->setQuantity($orderLine->getQuantity() + $quantity);
            $entityManager->persist($orderLine);
            if ($orderLine->getQuantity() == 0){
                $currentOrder->removeOrderLine($orderLine);
                $entityManager->remove($orderLine);
            }
            $entityManager->persist($currentOrder);
            if ($currentOrder->getOrderLines()->count() == 0){
                $entityManager->remove($currentOrder);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_order_index');
        }

        return $this->render('article/index.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}
