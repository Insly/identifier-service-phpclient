<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Dictionary\IdentifierService\ErrorCodes\Custom;
use Insly\Identifier\Client\Dictionary\IdentifierService\ErrorCodes\Standard;
use Insly\Identifier\Client\DTO\IdentifierService\IdentifierErrorResponse;
use Insly\Identifier\Client\DTO\IdentifierService\Response\Error;
use Insly\Identifier\Client\Exceptions\IdentifierService\AliasExistsException;
use Insly\Identifier\Client\Exceptions\IdentifierService\CodeDeliveryFailureException;
use Insly\Identifier\Client\Exceptions\IdentifierService\CodeMismatchException;
use Insly\Identifier\Client\Exceptions\IdentifierService\ConcurrentModificationException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\AccessTokenRequiredException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\EitherAccessTokenOrSessionRequiredException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\HashingException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\InvalidChallengeException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\PoolNotFoundException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\SoftwareTokenMFACodeRequiredException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\UsernameRequiredException;
use Insly\Identifier\Client\Exceptions\IdentifierService\Custom\ValidationException;
use Insly\Identifier\Client\Exceptions\IdentifierService\EnableSoftwareTokenMFAException;
use Insly\Identifier\Client\Exceptions\IdentifierService\ExpiredCodeException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InternalErrorException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidEmailRoleAccessPolicyException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidLambdaResponseException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidParameterException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidPasswordException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidSmsRoleAccessPolicyException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidSmsRoleTrustRelationshipException;
use Insly\Identifier\Client\Exceptions\IdentifierService\InvalidUserPoolConfigurationException;
use Insly\Identifier\Client\Exceptions\IdentifierService\LimitExceededException;
use Insly\Identifier\Client\Exceptions\IdentifierService\MFAMethodNotFoundException;
use Insly\Identifier\Client\Exceptions\IdentifierService\NotAuthorizedException;
use Insly\Identifier\Client\Exceptions\IdentifierService\PasswordResetRequiredException;
use Insly\Identifier\Client\Exceptions\IdentifierService\PreconditionNotMetException;
use Insly\Identifier\Client\Exceptions\IdentifierService\ResourceNotFoundException;
use Insly\Identifier\Client\Exceptions\IdentifierService\SoftwareTokenMFANotFoundException;
use Insly\Identifier\Client\Exceptions\IdentifierService\TooManyFailedAttemptsException;
use Insly\Identifier\Client\Exceptions\IdentifierService\TooManyRequestsException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UndefinedErrorException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UnexpectedLambdaException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UnsupportedUserStateException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UserLambdaValidationException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UsernameExistsException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UserNotConfirmedException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UserNotFoundException;
use Insly\Identifier\Client\Exceptions\IdentifierServiceClientException;
use Insly\Identifier\Client\Exceptions\UndefinedErrorCodeException;
use JsonException;

class IdentifierResponseHandler
{
    /**
     * @throws IdentifierServiceClientException
     * @throws JsonException
     */
    public function handle(IdentifierErrorResponse $response): void
    {
        $error = $this->getFirstError($response);
        $errorCode = $error->getErrorCode();

        $exception = $this->getExceptionForErrorCode($errorCode);
        $exceptionDetails = $this->createDetails($error);
        
        throw $exception->setDetails($exceptionDetails)->setCode($response->getStatusCode());
    }

    protected function getFirstError(IdentifierErrorResponse $response): Error
    {
        return $response->getErrors()[0];
    }

    protected function createDetails(Error $error): array
    {
        return [
            "identifierServiceDetails" => [
                "errorCode" => $error->getErrorCode(),
                "message" => $error->getMessage(),
            ],
        ];
    }

    protected function getExceptionForErrorCode(string $errorCode): IdentifierServiceClientException
    {
        return match ($errorCode) {
            Standard::IDS_10001 => new AliasExistsException(),
            Standard::IDS_10002 => new CodeDeliveryFailureException(),
            Standard::IDS_10003 => new CodeMismatchException(),
            Standard::IDS_10004 => new ConcurrentModificationException(),
            Standard::IDS_10005 => new EnableSoftwareTokenMFAException(),
            Standard::IDS_10006 => new ExpiredCodeException(),
            Standard::IDS_10007 => new InternalErrorException(),
            Standard::IDS_10008 => new InvalidEmailRoleAccessPolicyException(),
            Standard::IDS_10009 => new InvalidLambdaResponseException(),
            Standard::IDS_10010 => new InvalidParameterException(),
            Standard::IDS_10011 => new InvalidPasswordException(),
            Standard::IDS_10012 => new InvalidSmsRoleAccessPolicyException(),
            Standard::IDS_10013 => new InvalidSmsRoleTrustRelationshipException(),
            Standard::IDS_10014 => new InvalidUserPoolConfigurationException(),
            Standard::IDS_10015 => new LimitExceededException(),
            Standard::IDS_10016 => new MFAMethodNotFoundException(),
            Standard::IDS_10017 => new NotAuthorizedException(),
            Standard::IDS_10018 => new PasswordResetRequiredException(),
            Standard::IDS_10019 => new PreconditionNotMetException(),
            Standard::IDS_10020 => new ResourceNotFoundException(),
            Standard::IDS_10021 => new SoftwareTokenMFANotFoundException(),
            Standard::IDS_10022 => new TooManyFailedAttemptsException(),
            Standard::IDS_10023 => new TooManyRequestsException(),
            Standard::IDS_10024 => new UnexpectedLambdaException(),
            Standard::IDS_10025 => new UnsupportedUserStateException(),
            Standard::IDS_10026 => new UserLambdaValidationException(),
            Standard::IDS_10027 => new UsernameExistsException(),
            Standard::IDS_10028 => new UserNotConfirmedException(),
            Standard::IDS_10029 => new UserNotFoundException(),

            Custom::IDS_20001 => new PoolNotFoundException(),
            Custom::IDS_20002 => new InvalidChallengeException(),
            Custom::IDS_20003 => new EitherAccessTokenOrSessionRequiredException(),
            Custom::IDS_20004 => new UsernameRequiredException(),
            Custom::IDS_20005 => new HashingException(),
            Custom::IDS_20006 => new ValidationException(),
            Custom::IDS_20007 => new SoftwareTokenMFACodeRequiredException(),
            Custom::IDS_20008 => new AccessTokenRequiredException(),

            Standard::IDS_99999 => new UndefinedErrorException(),

            default => new UndefinedErrorCodeException(),
        };
    }
}
