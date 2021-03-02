<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Clients;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Entities\Builders\UserBuilder;
use Insly\Identifier\Client\Entities\User;
use Insly\Identifier\Client\Exceptions\InvalidTenantException;
use Insly\Identifier\Client\Exceptions\NotAuthorizedException;
use Psr\Http\Client\ClientExceptionInterface;

class UserClient extends Client
{
    /**
     * @throws ClientExceptionInterface
     * @throws NotAuthorizedException
     * @throws InvalidTenantException
     */
    public function getUser(): User
    {
        $this->login();

        $endpoint = $this->config->getHost() . "user";
        $request = new Request("GET", $endpoint, $this->buildHeaders());
        $response = $this->sendRequest($request);

        return UserBuilder::buildFromResponse(json_decode($response->getBody()->getContents(), true));
    }
}
