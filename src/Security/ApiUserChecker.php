<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        /* @var User $user */
        if (!$user->isApiEnabled()) {
            throw new ApiAccessDisabledException('API access is not enabled.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
