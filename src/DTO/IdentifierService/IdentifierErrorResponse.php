<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\DTO\IdentifierService;

use Insly\Identifier\Client\DTO\IdentifierService\Response\Error;

class IdentifierErrorResponse
{
    /**
     * @param Error[] $errors
     */
    public function __construct(
        protected array $errors,
        protected int $statusCode,
    ) {
    }

    public static function fromResponseContent(array $responseContent, int $statusCode): static
    {
        $errors = $responseContent["errors"];

        foreach ($errors as &$error) {
            $error = new Error(message: $error["message"], errorCode: $error["code"]);
        }

        return new static($errors, $statusCode);
    }

    /**
     * @return Error[]
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
