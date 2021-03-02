<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Exceptions\InvalidTenantException;
use Throwable;

class InvalidTenant extends ResponseExceptionHandler
{
    protected const ERROR_CODE = "tenant";

    protected function getCode(): string
    {
        return static::ERROR_CODE;
    }

    protected function getException(): Throwable
    {
        return new InvalidTenantException();
    }
}
