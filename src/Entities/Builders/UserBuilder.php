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

        $user->setId($userData["id"]);
        $user->setDomain($userData["user_attributes"]["custom:domain"] ?? "");
        $user->setCalclyCustomerId($userData["user_attributes"]["custom:calcly_customer_id"] ?? "");
        $user->setEmail($userData["user_attributes"]["email"]);
        $user->setEmailVerified($userData["user_attributes"]["email_verified"]);
        $user->setName($userData["user_attributes"]["name"]);
        $user->setSub($userData["user_attributes"]["sub"]);

        return $user;
    }
}
