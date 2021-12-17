<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing\ErrorResponseMocks;

class Custom
{
    public static function getPoolNotFoundExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20001",
                    "message" => "PoolNotFoundException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidChallengeExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20002",
                    "message" => "InvalidChallengeException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getEitherAccessTokenOrSessionRequiredExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20003",
                    "message" => "EitherAccessTokenOrSessionRequiredException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUsernameRequiredExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20004",
                    "message" => "UsernameRequiredException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getHashingExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20005",
                    "message" => "HashingException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getValidationExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20006",
                    "message" => "ValidationException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getSoftwareTokenMFACodeRequiredExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20007",
                    "message" => "SoftwareTokenMFACodeRequiredException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getAccessTokenRequiredExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS20008",
                    "message" => "AccessTokenRequiredException: example.",
                    "params" => [],
                ],
            ],
        ];
    }
}
