<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Clients;

use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Exceptions\FeatureNotImplementedException;

class PasswordClient extends Client
{
    /**
     * @throws FeatureNotImplementedException
     */
    public function reset(): void
    {
        throw new FeatureNotImplementedException();
    }

    /**
     * @throws FeatureNotImplementedException
     */
    public function update(): void
    {
        throw new FeatureNotImplementedException();
    }
}
