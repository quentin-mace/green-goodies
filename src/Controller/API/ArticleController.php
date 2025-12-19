<?php

namespace App\Controller\API;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/articles', name: 'api_articles')]
class ArticleController extends AbstractController
{
    /**
     * @throws ExceptionInterface
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
