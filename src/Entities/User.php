<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities;

use Insly\Identifier\Client\Exceptions\NoUserCustomDataException;

class User
{
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

    /**
     * @throws NoUserCustomDataException
     */
    public function getCustom(string $key): string
    {
        if (!$this->customAttributes[$key]) {
            throw new NoUserCustomDataException();
        }

        return $this->customAttributes[$key];
    }

    public function setCustom(string $key, string $value): void
    {
        $this->customAttributes[$key] = $value;
    }
}
