<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing;

class LoginMocks
{
    public static function getResponse(string $token = "test"): array
    {
        return [
            "AuthenticationResult" => [
                "AccessToken" => $token,
            ],
        ];
    }

    public static function getInvalidUsernameOrPasswordResponse(): array
    {
        return [
            "Errors" => [
                [
                    "Code" => "IDS99999",
                    "Message" => "NotAuthorizedException: Incorrect username or password.",
                    "Params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidTenantResponse(): array
    {
        return [
            "Errors" => [
                [
                    "Code" => "tenant",
                    "Message" => "pg: no rows in result set",
                    "Params" => [],
                ],
            ],
        ];
    }
}
