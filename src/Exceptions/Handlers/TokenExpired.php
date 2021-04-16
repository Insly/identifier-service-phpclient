<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Exceptions\TokenExpiredException;
use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;

class TokenExpired extends ResponseExceptionHandler
{
    protected const ERROR_CODE = "IDS99999";

    protected function getCode(): string
    {
        return static::ERROR_CODE;
    }

    protected function getException(): ValidationExceptionContract
    {
        return new TokenExpiredException();
    }

    protected function getMessagePart(): string
    {
        return "Access Token has expired";
    }
}
