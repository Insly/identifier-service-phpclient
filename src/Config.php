<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use Insly\Identifier\Client\Exceptions\InvalidHostFormatException;

class Config
{
    /** @var string */
    protected $tenant = "";
    /** @var string */
    protected $host = "";
    /** @var string */
    protected $token = "";
    /** @var string */
    protected $username = "";
    /** @var string */
    protected $password = "";
    /** @var array */
    protected $loginMeta = [];

    /**
     * @throws InvalidHostFormatException
     */
    public function __construct(string $host, string $tenant)
    {
        $this->setHost($host);
        $this->setTenant($tenant);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @throws InvalidHostFormatException
     */
    public function setHost(string $host, bool $validate = true): void
    {
        if ($validate) {
            if (substr($host, -1) !== "/") {
                throw new InvalidHostFormatException("Host must be ending with slash sign.");
            }
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

    public function getLoginMeta(): array
    {
        return $this->loginMeta;
    }

    public function setLoginMeta(array $meta): void
    {
        $this->loginMeta = $meta;
    }
}
