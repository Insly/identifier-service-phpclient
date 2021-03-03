<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Exceptions\InvalidTenantException;
use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;

class InvalidTenant extends ResponseExceptionHandler
{
    protected const ERROR_CODE = "tenant";

    protected function getCode(): string
    {
        return static::ERROR_CODE;
    }

    protected function getException(): ValidationExceptionContract
    {
        return new InvalidTenantException();
    }
}
