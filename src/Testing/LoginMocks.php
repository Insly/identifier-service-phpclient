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
                    "code" => "IDS10017",
                    "message" => "NotAuthorizedException: Incorrect username or password.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getTokenExpiredResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10017",
                    "message" => "NotAuthorizedException: Access Token has expired",
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
                    "code" => "IDS99999",
                    "message" => "pg: no rows in result set",
                    "params" => [],
                ],
            ],
        ];
    }
}
