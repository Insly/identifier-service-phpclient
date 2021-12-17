<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Testing\ErrorResponseMocks;

class Standard
{
    public static function getAliasExistsExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10001",
                    "message" => "AliasExistsException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getCodeDeliveryFailureExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10002",
                    "message" => "CodeDeliveryFailureException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getCodeMismatchExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10003",
                    "message" => "CodeMismatchException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getConcurrentModificationExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10004",
                    "message" => "ConcurrentModificationException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getEnableSoftwareTokenMFAExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10005",
                    "message" => "EnableSoftwareTokenMFAException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getExpiredCodeExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10006",
                    "message" => "ExpiredCodeException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInternalErrorExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10007",
                    "message" => "InternalErrorException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidEmailRoleAccessPolicyExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10008",
                    "message" => "InvalidEmailRoleAccessPolicyException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidLambdaResponseExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10009",
                    "message" => "InvalidLambdaResponseException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidParameterExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10010",
                    "message" => "InvalidParameterException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidPasswordExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10011",
                    "message" => "InvalidPasswordException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidSmsRoleAccessPolicyExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10012",
                    "message" => "InvalidSmsRoleAccessPolicyException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidSmsRoleTrustRelationshipExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10013",
                    "message" => "InvalidSmsRoleTrustRelationshipException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getInvalidUserPoolConfigurationExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10014",
                    "message" => "InvalidUserPoolConfigurationException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getLimitExceededExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10015",
                    "message" => "LimitExceededException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getMFAMethodNotFoundExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10016",
                    "message" => "MFAMethodNotFoundException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getNotAuthorizedExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10017",
                    "message" => "NotAuthorizedException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getPasswordResetRequiredExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10018",
                    "message" => "PasswordResetRequiredException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getPreconditionNotMetExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10019",
                    "message" => "PreconditionNotMetException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getResourceNotFoundExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10020",
                    "message" => "ResourceNotFoundException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getSoftwareTokenMFANotFoundExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10021",
                    "message" => "SoftwareTokenMFANotFoundException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getTooManyFailedAttemptsExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10022",
                    "message" => "TooManyFailedAttemptsException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getTooManyRequestsExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10023",
                    "message" => "TooManyRequestsException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUnexpectedLambdaExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10024",
                    "message" => "UnexpectedLambdaException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUnsupportedUserStateExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10025",
                    "message" => "UnsupportedUserStateException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUserLambdaValidationExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10026",
                    "message" => "UserLambdaValidationException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUsernameExistsExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10027",
                    "message" => "UsernameExistsException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUserNotConfirmedExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10028",
                    "message" => "UserNotConfirmedException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUserNotFoundExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS10029",
                    "message" => "UserNotFoundException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUndefinedErrorExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "IDS99999",
                    "message" => "UndefinedErrorException: example.",
                    "params" => [],
                ],
            ],
        ];
    }

    public static function getUndefinedErrorCodeExceptionResponse(): array
    {
        return [
            "errors" => [
                [
                    "code" => "undefined",
                    "message" => "UndefinedErrorCodeException",
                    "params" => [],
                ],
            ],
        ];
    }
}
