<?php

namespace App\Factory;

use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<User>
 */
final class UserFactory extends PersistentObjectFactory
{
    #[\Override]
    public static function class(): string
    {
        return User::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'apiEnabled' => self::faker()->boolean(),
            'email' => self::faker()->text(180),
            'firstName' => self::faker()->text(255),
            'lastName' => self::faker()->text(255),
            'password' => self::faker()->text(),
            'roles' => [],
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
