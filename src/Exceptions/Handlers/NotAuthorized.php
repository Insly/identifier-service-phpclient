<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Exceptions\NotAuthorizedException;
use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;

class NotAuthorized extends ResponseExceptionHandler
{
    protected const ERROR_CODE = "IDS10017";

    protected function getCode(): string
    {
        return static::ERROR_CODE;
    }

    protected function getException(): ValidationExceptionContract
    {
        return new NotAuthorizedException();
    }

    protected function getMessagePart(): string
    {
        return "Incorrect username or password";
    }
}