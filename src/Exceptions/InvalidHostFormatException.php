<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidHostFormatException extends Exception
{
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
