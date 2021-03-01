<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Entities\Builders\UserBuilder;
use Insly\Identifier\Client\Entities\User;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    protected ClientInterface $client;
    protected Config $config;
    protected string $token = "";

    public function __construct(ClientInterface $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function login(string $username, string $password): ResponseInterface
    {
        $endpoint = $this->config->getHost() . "login/" . $this->config->getTenant();
        $credentials = [
            "username" => $username,
            "password" => $password,
        ];

        $request = new Request("POST", $endpoint, [], json_encode($credentials));

        $response = $this->client->sendRequest($request);
        $this->token = json_decode($response->getBody()->getContents(), true)["AuthenticationResult"]["AccessToken"];

        return $response;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getUser(): User
    {
        $endpoint = $this->config->getHost() . "user";
        $request = new Request("GET", $endpoint, ["Authorization" => "Bearer " . $this->token]);
        $response = $this->client->sendRequest($request);

        return UserBuilder::buildFromResponse(json_decode($response->getBody()->getContents(), true));
    }
}
