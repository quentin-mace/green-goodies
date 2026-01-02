<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Service\Handler\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller gérant l'affichage et l'ajout d'articles au panier.
 *
 * Ce controller permet de :
 * - Afficher les détails d'un article
 * - Ajouter un article au panier avec une quantité spécifiée
 */
final class ArticleController extends AbstractController
{
    /**
     * Affiche la page de détail d'un article et permet de l'ajouter au panier.
     *
     * @return Response Page de détail de l'article
     */
    #[Route('/article/{id}', name: 'app_article', requirements: ['id' => "\d+"], methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('app_cart');
        }

        return $this->render('article/index.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }
}
