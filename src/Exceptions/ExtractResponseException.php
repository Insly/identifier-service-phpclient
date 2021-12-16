<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;
use Throwable;

class ExtractResponseException extends Exception
{
    protected $message = "An error occurred during retrieving response from the Identifier service.";

    public function __construct(?Throwable $previous = null)
    {
        parent::__construct(message: $this->message, previous: $previous);
    }
}
