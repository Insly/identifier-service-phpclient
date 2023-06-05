<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Dictionary\IdentifierService\ErrorCodes\Custom as CustomErrorCodes;
use Insly\Identifier\Client\Dictionary\IdentifierService\ErrorCodes\Standard as StandardErrorCodes;
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
use Insly\Identifier\Client\Exceptions\UndefinedErrorCodeException;
use Insly\Identifier\Client\Testing\ErrorResponseMocks\Custom;
use Insly\Identifier\Client\Testing\ErrorResponseMocks\Standard;
use Insly\Identifier\Client\Testing\TestCase;

class ErrorResponseHandlerTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testClientIsNotValidateCorrectResponse(): void
    {
        $response = new Response(status: 200, body: json_encode([]));
        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $validateResponseMethod = $this->getProtectedMethod(Client::class, "validateResponse");

        $validateResponseMethod->invokeArgs($client, [
            "response" => $response,
        ]);

        $this->expectNotToPerformAssertions();
    }

    /**
     * @throws ReflectionException
     */
    public function testClientIsAbleToHandleUndefinedErrorCodeResponse(): void
    {
        $this->expectException(UndefinedErrorCodeException::class);

        $responseArray = Standard::getUndefinedErrorCodeExceptionResponse();
        $response = new Response(status: 400, body: json_encode($responseArray));
        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $validateResponseMethod = $this->getProtectedMethod(Client::class, "validateResponse");

        $validateResponseMethod->invokeArgs($client, [
            "response" => $response,
        ]);
    }

    /**
     * @dataProvider provideErrorCodesWithExceptionsAndResponses
     * @throws ReflectionException
     */
    public function testClientIsAbleToHandleErrorResponse(string $exceptionClass, array $responseArray, string $errorCode): void
    {
        $this->expectException($exceptionClass);
        // check if errorCode exists in the exception message
        $errorCodeRegex = "/{$errorCode}/";
        $this->expectExceptionMessageMatches($errorCodeRegex);

        $response = new Response(status: 400, body: json_encode($responseArray));
        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $validateResponseMethod = $this->getProtectedMethod(Client::class, "validateResponse");

        $validateResponseMethod->invokeArgs($client, [
            "response" => $response,
        ]);
    }

    public function provideErrorCodesWithExceptionsAndResponses(): Generator
    {
        yield StandardErrorCodes::IDS_10001 => [
            "exception" => AliasExistsException::class,
            "response" => Standard::getAliasExistsExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10001,
        ];
        yield StandardErrorCodes::IDS_10002 => [
            "exception" => CodeDeliveryFailureException::class,
            "response" => Standard::getCodeDeliveryFailureExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10002,
        ];
        yield StandardErrorCodes::IDS_10003 => [
            "exception" => CodeMismatchException::class,
            "response" => Standard::getCodeMismatchExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10003,
        ];
        yield StandardErrorCodes::IDS_10004 => [
            "exception" => ConcurrentModificationException::class,
            "response" => Standard::getConcurrentModificationExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10004,
        ];
        yield StandardErrorCodes::IDS_10005 => [
            "exception" => EnableSoftwareTokenMFAException::class,
            "response" => Standard::getEnableSoftwareTokenMFAExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10005,
        ];
        yield StandardErrorCodes::IDS_10006 => [
            "exception" => ExpiredCodeException::class,
            "response" => Standard::getExpiredCodeExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10006,
        ];
        yield StandardErrorCodes::IDS_10007 => [
            "exception" => InternalErrorException::class,
            "response" => Standard::getInternalErrorExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10007,
        ];
        yield StandardErrorCodes::IDS_10008 => [
            "exception" => InvalidEmailRoleAccessPolicyException::class,
            "response" => Standard::getInvalidEmailRoleAccessPolicyExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10008,
        ];
        yield StandardErrorCodes::IDS_10009 => [
            "exception" => InvalidLambdaResponseException::class,
            "response" => Standard::getInvalidLambdaResponseExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10009,
        ];
        yield StandardErrorCodes::IDS_10010 => [
            "exception" => InvalidParameterException::class,
            "response" => Standard::getInvalidParameterExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10010,
        ];
        yield StandardErrorCodes::IDS_10011 => [
            "exception" => InvalidPasswordException::class,
            "response" => Standard::getInvalidPasswordExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10011,
        ];
        yield StandardErrorCodes::IDS_10012 => [
            "exception" => InvalidSmsRoleAccessPolicyException::class,
            "response" => Standard::getInvalidSmsRoleAccessPolicyExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10012,
        ];
        yield StandardErrorCodes::IDS_10013 => [
            "exception" => InvalidSmsRoleTrustRelationshipException::class,
            "response" => Standard::getInvalidSmsRoleTrustRelationshipExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10013,
        ];
        yield StandardErrorCodes::IDS_10014 => [
            "exception" => InvalidUserPoolConfigurationException::class,
            "response" => Standard::getInvalidUserPoolConfigurationExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10014,
        ];
        yield StandardErrorCodes::IDS_10015 => [
            "exception" => LimitExceededException::class,
            "response" => Standard::getLimitExceededExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10015,
        ];
        yield StandardErrorCodes::IDS_10016 => [
            "exception" => MFAMethodNotFoundException::class,
            "response" => Standard::getMFAMethodNotFoundExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10016,
        ];
        yield StandardErrorCodes::IDS_10017 => [
            "exception" => NotAuthorizedException::class,
            "response" => Standard::getNotAuthorizedExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10017,
        ];
        yield StandardErrorCodes::IDS_10018 => [
            "exception" => PasswordResetRequiredException::class,
            "response" => Standard::getPasswordResetRequiredExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10018,
        ];
        yield StandardErrorCodes::IDS_10019 => [
            "exception" => PreconditionNotMetException::class,
            "response" => Standard::getPreconditionNotMetExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10019,
        ];
        yield StandardErrorCodes::IDS_10020 => [
            "exception" => ResourceNotFoundException::class,
            "response" => Standard::getResourceNotFoundExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10020,
        ];
        yield StandardErrorCodes::IDS_10021 => [
            "exception" => SoftwareTokenMFANotFoundException::class,
            "response" => Standard::getSoftwareTokenMFANotFoundExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10021,
        ];
        yield StandardErrorCodes::IDS_10022 => [
            "exception" => TooManyFailedAttemptsException::class,
            "response" => Standard::getTooManyFailedAttemptsExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10022,
        ];
        yield StandardErrorCodes::IDS_10023 => [
            "exception" => TooManyRequestsException::class,
            "response" => Standard::getTooManyRequestsExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10023,
        ];
        yield StandardErrorCodes::IDS_10024 => [
            "exception" => UnexpectedLambdaException::class,
            "response" => Standard::getUnexpectedLambdaExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10024,
        ];
        yield StandardErrorCodes::IDS_10025 => [
            "exception" => UnsupportedUserStateException::class,
            "response" => Standard::getUnsupportedUserStateExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10025,
        ];
        yield StandardErrorCodes::IDS_10026 => [
            "exception" => UserLambdaValidationException::class,
            "response" => Standard::getUserLambdaValidationExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10026,
        ];
        yield StandardErrorCodes::IDS_10027 => [
            "exception" => UsernameExistsException::class,
            "response" => Standard::getUsernameExistsExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10027,
        ];
        yield StandardErrorCodes::IDS_10028 => [
            "exception" => UserNotConfirmedException::class,
            "response" => Standard::getUserNotConfirmedExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10028,
        ];
        yield StandardErrorCodes::IDS_10029 => [
            "exception" => UserNotFoundException::class,
            "response" => Standard::getUserNotFoundExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_10029,
        ];
        yield CustomErrorCodes::IDS_20001 => [
            "exception" => PoolNotFoundException::class,
            "response" => Custom::getPoolNotFoundExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20001,
        ];
        yield CustomErrorCodes::IDS_20002 => [
            "exception" => InvalidChallengeException::class,
            "response" => Custom::getInvalidChallengeExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20002,
        ];
        yield CustomErrorCodes::IDS_20003 => [
            "exception" => EitherAccessTokenOrSessionRequiredException::class,
            "response" => Custom::getEitherAccessTokenOrSessionRequiredExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20003,
        ];
        yield CustomErrorCodes::IDS_20004 => [
            "exception" => UsernameRequiredException::class,
            "response" => Custom::getUsernameRequiredExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20004,
        ];
        yield CustomErrorCodes::IDS_20005 => [
            "exception" => HashingException::class,
            "response" => Custom::getHashingExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20005,
        ];
        yield CustomErrorCodes::IDS_20006 => [
            "exception" => ValidationException::class,
            "response" => Custom::getValidationExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20006,
        ];
        yield CustomErrorCodes::IDS_20007 => [
            "exception" => SoftwareTokenMFACodeRequiredException::class,
            "response" => Custom::getSoftwareTokenMFACodeRequiredExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20007,
        ];
        yield CustomErrorCodes::IDS_20008 => [
            "exception" => AccessTokenRequiredException::class,
            "response" => Custom::getAccessTokenRequiredExceptionResponse(),
            "errorCode" => CustomErrorCodes::IDS_20008,
        ];
        yield StandardErrorCodes::IDS_99999 => [
            "exception" => UndefinedErrorException::class,
            "response" => Standard::getUndefinedErrorExceptionResponse(),
            "errorCode" => StandardErrorCodes::IDS_99999,
        ];
    }
}
