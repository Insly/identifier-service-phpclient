<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

class Config
{
    protected string $tenant = "";
    protected string $host = "";
    protected string $token = "";
    protected string $username = "";
    protected string $password = "";

    public function __construct(string $host, string $tenant)
    {
        $this->setHost($host);
        $this->setTenant($tenant);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        if (!str_ends_with($host, "/")) {
            $host .= "/";
        }

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

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}
