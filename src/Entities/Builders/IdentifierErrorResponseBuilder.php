<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities\Builders;

use Insly\Identifier\Client\DTO\IdentifierService\IdentifierErrorResponse;
use Insly\Identifier\Client\DTO\IdentifierService\Response\Error;

class IdentifierErrorResponseBuilder
{
    public static function fromResponseContent(array $responseContent, int $statusCode): IdentifierErrorResponse
    {
        $errors = $responseContent["errors"];

        foreach ($errors as &$error) {
            $error = new Error(message: $error["message"], errorCode: $error["code"]);
        }

        return new IdentifierErrorResponse($errors, $statusCode);
    }
}
