<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\DTO\IdentifierService\Response;

class Error
{
    public function __construct(
        protected string $message,
        protected string $errorCode,
    ) {}

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
