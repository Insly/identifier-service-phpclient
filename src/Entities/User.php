<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities;

use Insly\Identifier\Client\Exceptions\NoUserCustomDataException;

class User
{
    public const CUSTOM_PREFIX = "custom:";

    protected string $id;
    protected string $email;
    protected string $emailVerified;
    protected string $name;
    protected string $sub;
    protected ?string $profile;
    protected array $customAttributes = [];
    protected array $apiGroups = [];

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

    public function setProfile(?string $profile): void
    {
        $this->profile = $profile;
    }

    public function getProfile(): ?string
    {
        return $this->profile ?? null;
    }

    public function getCustom(string $key): ?string
    {
        return $this->customAttributes[static::CUSTOM_PREFIX . $key] ?? null;
    }

    public function getCustomAttributes(): array
    {
        return $this->customAttributes;
    }

    /**
     * @throws NoUserCustomDataException
     */
    public function getRequiredCustom(string $key): string
    {
        return $this->getCustom($key) ?? throw new NoUserCustomDataException();
    }

    public function setCustom(string $key, string $value): void
    {
        $this->customAttributes[$key] = $value;
    }

    public function setApiGroups(array $groups): void
    {
        $this->apiGroups = $groups;
    }

    public function getApiGroups(): array
    {
        return $this->apiGroups;
    }
}
