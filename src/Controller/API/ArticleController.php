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

#[Route('/api/articles', name: 'api_articles')]
class ArticleController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('', name: '')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(SerializerInterface $serializer, ArticleRepository $repository): JsonResponse
    {
        $articleList = $repository->findAll();
        $jsonArticles = $serializer->serialize($articleList, 'json', ['groups' => 'article:read']);

        return new JsonResponse($jsonArticles, Response::HTTP_OK, [], json: true);
    }
}
