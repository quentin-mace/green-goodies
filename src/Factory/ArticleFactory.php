<?php

namespace App\Factory;

use App\Entity\Article;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Article>
 */
final class ArticleFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return Article::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'fullDescription' => self::faker()->text(),
            'name' => self::faker()->text(255),
            'price' => self::faker()->randomNumber(),
            'shortDescription' => self::faker()->text(255),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Article $article): void {})
        ;
    }
}
