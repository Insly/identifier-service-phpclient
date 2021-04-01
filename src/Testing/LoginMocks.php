<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing;

class LoginMocks
{
    public static function getResponse(string $token = "test"): array
    {
        return [
            "authentication_result" => [
                "access_token" => $token,
            ],
        ];
    }

    public static function getInvalidUsernameOrPasswordResponse(): array
    {
        return [
            "errors" => [
                [
                    "dode" => "IDS99999",
                    "message" => "NotAuthorizedException: Incorrect username or password.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidTenantResponse(): array
    {
        return [
            "errors" => [
                [
                    "dode" => "tenant",
                    "message" => "pg: no rows in result set",
                    "params" => [],
                ],
            ],
        ];
    }
}
