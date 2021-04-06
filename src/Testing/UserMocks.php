<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing;

class UserMocks
{
    public static function getResponse(): array
    {
        return [
            "id" => "00000000-0000-0000-0000-000000000000",
            "preferred_mfa_setting" => "",
            "user_attributes" => [
                "email" => "user@example.com",
                "email_verified" => "true",
                "name" => "user@example.com",
                "sub" => "00000000-0000-0000-0000-000000000000",
            ],
            "user_mfa_settings" => [],
        ];
    }

    public static function getResponseWithCustomData(): array
    {
        return [
            "id" => "00000000-0000-0000-0000-000000000000",
            "preferred_mfa_setting" => "",
            "user_attributes" => [
                "custom:test" => "test",
                "email" => "user@example.com",
                "email_verified" => "true",
                "name" => "user@example.com",
                "sub" => "00000000-0000-0000-0000-000000000000",
            ],
            "user_mfa_settings" => [],
        ];
    }
}
