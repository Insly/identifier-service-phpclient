<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Exceptions\Handlers;

class HeaderTokenExpired extends TokenExpired
{
    protected const ERROR_CODE = "IDS10017";
}
