<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing;

class RequestMocks
{
    public static function getLogin(string $username, string $password, array $meta): array
    {
        return [
            "username" => $username,
            "password" => $password,
            "meta_data" => $meta,
        ];
    }
}
