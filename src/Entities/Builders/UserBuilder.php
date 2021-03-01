<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities\Builders;

use Insly\Identifier\Client\Entities\User;

class UserBuilder
{
    protected function __construct()
    {
    }

    public static function buildFromResponse($userData): User
    {
        $user = new User();
        $user->setId($userData["ID"]);

        return $user;
    }
}
