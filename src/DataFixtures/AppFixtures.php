<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $articles = $this->loadArticlesData();
        $this->createArticles($articles);

        $users = $this->loadUsersData();
        $this->createUsers($users);
    }

    private function createArticles(array $articles): void
    {
        foreach ($articles as $articleData) {
            ArticleFactory::createOne($articleData);
        }
    }

    private function createUsers(array $users): void
    {
        foreach ($users as $userData) {
            UserFactory::createOne($userData);
        }
    }

    private function loadArticlesData(): array
    {
        $filePath = __DIR__.'/../../config/fixtures/articles.yaml';
        $data = Yaml::parseFile($filePath);

        return $data['articles'] ?? [];
    }

    private function loadUsersData(): array
    {
        $filePath = __DIR__.'/../../config/fixtures/users.yaml';
        $data = Yaml::parseFile($filePath);

        return $data['users'] ?? [];
    }
}
