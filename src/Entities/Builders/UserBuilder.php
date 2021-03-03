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
        $user->setPreferredMfaSetting($userData["PreferredMfaSetting"]);
        $user->setAgency($userData["UserAttributes"]["custom:agency"]);
        $user->setNetwork($userData["UserAttributes"]["custom:network"]);
        $user->setEmail($userData["UserAttributes"]["email"]);
        $user->setEmailVerified($userData["UserAttributes"]["email_verified"]);
        $user->setName($userData["UserAttributes"]["name"]);
        $user->setSub($userData["UserAttributes"]["sub"]);

        return $user;
    }
}
