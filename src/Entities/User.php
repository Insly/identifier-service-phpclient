<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities;

class User
{
    protected string $id;
    protected string $domain;
    protected string $email;
    protected string $emailVerified;
    protected string $name;
    protected string $sub;
    protected string $calclyCustomerId;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
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

    public function getCalclyCustomerId(): string
    {
        return $this->calclyCustomerId;
    }

    public function setCalclyCustomerId(string $id): void
    {
        $this->calclyCustomerId = $id;
    }
}
