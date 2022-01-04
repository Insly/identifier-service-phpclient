<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities\Builders;

use Insly\Identifier\Client\Entities\User;

class UserBuilder
{
    protected function __construct()
    {
    }

    public static function buildFromResponse(array $userData): User
    {
        $user = new User();

        $user->setId($userData["id"]);
        $user->setEmail($userData["user_attributes"]["email"]);
        $user->setEmailVerified($userData["user_attributes"]["email_verified"]);
        $user->setName($userData["user_attributes"]["name"]);
        $user->setSub($userData["user_attributes"]["sub"]);

        $attributes = array_filter(
            $userData["user_attributes"],
            fn(string $value, string $key): bool => str_starts_with($key, User::CUSTOM_PREFIX),
            ARRAY_FILTER_USE_BOTH,
        );

        foreach ($attributes as $key => $value) {
            $user->setCustom($key, $value);
        }

        return $user;
    }
}
