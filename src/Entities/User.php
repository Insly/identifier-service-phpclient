<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Entities;

class User
{
    protected string $id;
    protected string $preferredMfaSetting;
    protected string $agency;
    protected string $network;
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

    public function getPreferredMfaSetting(): string
    {
        return $this->preferredMfaSetting;
    }

    public function setPreferredMfaSetting(string $preferredMfaSetting): void
    {
        $this->preferredMfaSetting = $preferredMfaSetting;
    }

    public function getAgency(): string
    {
        return $this->agency;
    }

    public function setAgency(string $agency): void
    {
        $this->agency = $agency;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function setNetwork(string $network): void
    {
        $this->network = $network;
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
