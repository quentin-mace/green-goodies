<?php

namespace App\Controller\API;

use App\Repository\ArticleRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * Controller API pour la gestion des articles.
 *
 * Ce controller fournit des endpoints REST pour accéder aux articles.
 * L'accès est réservé aux utilisateurs authentifiés ayant activé l'accès API.
 */
#[Route('/api/articles', name: 'api_articles')]
class ArticleController extends AbstractController
{
    /**
     * Retourne la liste de tous les articles au format JSON.
     *
     * Les articles sont sérialisés avec le groupe 'article:read'.
     * Un système de cache est utilisé pour améliorer les performances.
     *
     * @return JsonResponse Liste des articles au format JSON
     * @throws ExceptionInterface|InvalidArgumentException
     */
    #[Route('', name: '')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(
        SerializerInterface $serializer,
        ArticleRepository $repository,
        TagAwareCacheInterface $cache,
    ): JsonResponse {
        $idCache = 'articlesIndex';

        $articleList = $cache->get($idCache, function (ItemInterface $item) use ($repository) {
            $item->tag('articlesIndex');

            return $repository->findAll();
        });

        $articleList = $repository->findAll();
        $jsonArticles = $serializer->serialize($articleList, 'json', ['groups' => 'article:read']);

        return new JsonResponse($jsonArticles, Response::HTTP_OK, [], json: true);
    }
}
