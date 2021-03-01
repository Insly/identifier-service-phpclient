<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

class Config
{
    protected string $tenant;
    protected string $host;

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getTenant(): string
    {
        return $this->tenant;
    }

    public function setTenant(string $tenant): void
    {
        $this->tenant = $tenant;
    }
}
