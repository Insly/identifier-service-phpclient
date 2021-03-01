<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use Insly\Identifier\Client\Entities\User;

interface ClientContract
{
    public function login(string $username, string $password): self;

    public function logout(): self;

    public function user(): User;
}
