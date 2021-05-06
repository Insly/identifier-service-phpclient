<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities\Builders;

use Insly\Identifier\Client\Entities\User;

class UserBuilder
{
    protected const CUSTOM_PREFIX = "custom:";

    protected function __construct()
    {
    }

    public static function buildFromResponse($userData): User
    {
        $user = new User();

        $user->setId($userData["id"]);
        $user->setCustom("calcly_customer_id", $userData["user_attributes"]["custom:calcly_customer_id"] ?? "");
        $user->setEmail($userData["user_attributes"]["email"]);
        $user->setEmailVerified($userData["user_attributes"]["email_verified"]);
        $user->setName($userData["user_attributes"]["name"]);
        $user->setSub($userData["user_attributes"]["sub"]);

        $attributes = array_filter(
            $userData["user_attributes"],
            function (string $value, string $key): bool {
                return str_starts_with($key, static::CUSTOM_PREFIX);
            },
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($attributes as $key => $value) {
            $key = str_replace(static::CUSTOM_PREFIX, "", $key);
            $user->setCustom($key, $value);
        }

        return $user;
    }
}
