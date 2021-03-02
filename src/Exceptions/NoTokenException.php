<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;

class NoTokenException extends Exception
{
    protected $code = 400;
}
