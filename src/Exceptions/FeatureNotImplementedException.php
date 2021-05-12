<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class FeatureNotImplementedException extends Exception
{
    protected $code = Response::HTTP_NOT_IMPLEMENTED;
}
