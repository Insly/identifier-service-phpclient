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
            if (!$this->getMessagePart() || $this->isMessagePresent($this->getMessagePart(), $errors)) {
                throw $this->getException();
            }
        }
    }

    protected function isErrorCodePresent(string $code, array $errors): bool
    {
        return in_array($code, array_map(fn(array $error): string => $error["code"], $errors), true);
    }

    protected function getMessagePart(): string
    {
        return "";
    }

    protected function isMessagePresent(string $part, array $errors): bool
    {
        foreach (array_map(fn(array $error): string => $error["message"], $errors) as $message) {
            if (str_contains($message, $part)) {
                return true;
            }
        }

        return false;
    }

    abstract protected function getCode(): string;

    abstract protected function getException(): ValidationExceptionContract;
}
