<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;

abstract class ResponseExceptionHandler
{
    /**
     * @throws ValidationExceptionContract
     */
    public function validate(array $errors): void
    {
        if ($this->isErrorCodePresent($this->getCode(), $errors)) {
            throw $this->getException();
        }
    }

    protected function isErrorCodePresent(string $code, array $errors): bool
    {
        return in_array($code, array_map(fn (array $error): string => $error["code"], $errors), true);
    }

    abstract protected function getCode(): string;

    abstract protected function getException(): ValidationExceptionContract;
}
