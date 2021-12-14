<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;

class ExtractResponseException extends Exception
{
    protected $message = "An error occurred during retrieving response from the Identifier service.";
}
