<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

class IdentifierServiceClientException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
    protected $message = "Request to the Identifier service failed.";

    /**
     * @throws JsonException
     */
    public function setDetails(array $details): static
    {
        $detailsJson = json_encode($details, flags: JSON_THROW_ON_ERROR);
        $this->message .= " [Details: ${detailsJson}]";

        return $this;
    }

    public function setCode(int $statusCode): static
    {
        $this->code = $statusCode;

        return $this;
    }
}
