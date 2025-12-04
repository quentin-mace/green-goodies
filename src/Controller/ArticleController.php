<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\User;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use App\Service\Handler\CartHandler;
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
    public function index(Article $article, Request $request, CartHandler $cartHandler): Response
    {
        $form = $this->createFormBuilder()
            ->add('quantity', NumberType::class, ['label' => false])
            ->add('save', SubmitType::class, ['label' => 'Ajouter au panier'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $form->getData()['quantity'];

            /** @var User $client */
            $client = $this->getUser();

            $cartHandler->addToCart($article, $client, $quantity);

            return $this->redirectToRoute('admin_order_index');
        }

        return $this->render('article/index.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}
