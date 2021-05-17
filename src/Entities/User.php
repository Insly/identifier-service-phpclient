<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities;

use Insly\Identifier\Client\Exceptions\NoUserCustomDataException;

class User
{
    public const CUSTOM_PREFIX = "custom:";

    /** @var string */
    protected $id;
    /** @var string */
    protected $email;
    /** @var string */
    protected $emailVerified;
    /** @var string */
    protected $name;
    /** @var string */
    protected $sub;
    /** @var array */
    protected $customAttributes = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmailVerified(): string
    {
        return $this->emailVerified;
    }

    public function setEmailVerified(string $emailVerified): void
    {
        $this->emailVerified = $emailVerified;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSub(): string
    {
        return $this->sub;
    }

    public function setSub(string $sub): void
    {
        $this->sub = $sub;
    }

    public function getCustom(string $key): ?string
    {
        return $this->customAttributes[static::CUSTOM_PREFIX . $key] ?? null;
    }

    /**
     * @throws NoUserCustomDataException
     */
    public function getRequiredCustom(string $key): string
    {
        if (!isset($this->customAttributes[$key])) {
            throw new NoUserCustomDataException();
        }

        return $this->getCustom($key);
    }

    public function setCustom(string $key, string $value): void
    {
        $this->customAttributes[$key] = $value;
    }
}
