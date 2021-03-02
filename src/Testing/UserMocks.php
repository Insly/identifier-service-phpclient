<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing;

class UserMocks
{
    public static function getResponse(): array
    {
        return [
            "ID" => "00000000-0000-0000-0000-000000000000",
            "PreferredMfaSetting" => "",
            "UserAttributes" => [
                "custom:agency" => "agency",
                "custom:network" => "network",
                "email" => "user@example.com",
                "email_verified" => "true",
                "name" => "user@example.com",
                "sub" => "00000000-0000-0000-0000-000000000000",
            ],
            "UserMFASettingList" => [],
        ];
    }
}
