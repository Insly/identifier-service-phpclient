<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Exceptions\NotAuthorizedException;
use Throwable;

class NotAuthorized extends ResponseExceptionHandler
{
    protected const ERROR_CODE = "IDS99999";

    protected function getCode(): string
    {
        return static::ERROR_CODE;
    }

    protected function getException(): Throwable
    {
        return new NotAuthorizedException();
    }
}
