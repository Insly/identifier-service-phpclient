<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TokenExpiredException extends Exception implements ValidationExceptionContract
{
    protected $code = Response::HTTP_UNAUTHORIZED;
}
