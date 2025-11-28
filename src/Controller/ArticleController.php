<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_article', requirements: ['id' => "\d+"])]
    public function index(Article $article): Response
    {
        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }
}
