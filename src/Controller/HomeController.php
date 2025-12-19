<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller gérant la page d'accueil du site.
 *
 * Ce controller affiche la liste de tous les articles disponibles sur la page d'accueil.
 *
 * @final
 */
final class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil avec la liste de tous les articles.
     *
     * @return Response Page d'accueil
     */
    #[Route('', name: 'app_home', methods: ['GET'])]
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
