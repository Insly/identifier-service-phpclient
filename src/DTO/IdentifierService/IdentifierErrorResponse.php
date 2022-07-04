<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\DTO\IdentifierService;

use Insly\Identifier\Client\DTO\IdentifierService\Response\Error;

class IdentifierErrorResponse
{
    /**
     * @param array<Error> $errors
     */
    public function __construct(
        protected array $errors,
        protected int $statusCode,
    ) {}

    /**
     * @return array<Error>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
