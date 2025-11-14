<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<User>
 */
final class UserFactory extends PersistentObjectFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

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
        return $this
            ->afterInstantiate(function (User $user, array $attributes): void {
                // Si un mot de passe en clair est fourni, le hasher automatiquement
                if (isset($attributes['plainPassword'])) {
                    $hashedPassword = $this->passwordHasher->hashPassword($user, $attributes['plainPassword']);
                    $user->setPassword($hashedPassword);
                }
            })
        ;
    }
}
