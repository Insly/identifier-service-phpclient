<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Entities\Builders\UserBuilder;
use Insly\Identifier\Client\Entities\User;
use Insly\Identifier\Client\Exceptions\InvalidTenantException;
use Insly\Identifier\Client\Exceptions\NotAuthorizedException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

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
     * @throws NotAuthorizedException
     */
    public function login(string $username, string $password): ResponseInterface
    {
        $endpoint = $this->config->getHost() . "login/" . $this->config->getTenant();
        $credentials = [
            "username" => $username,
            "password" => $password,
        ];

        $request = new Request("POST", $endpoint, [], json_encode($credentials));
        $response = $this->sendRequest($request);
        $content = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            if ($this->isErrorCodePresent("IDS99999", $content["Errors"])) {
                throw new NotAuthorizedException();
            }

            if ($this->isErrorCodePresent("tenant", $content["Errors"])) {
                throw new InvalidTenantException();
            }
        }

        $this->token = $content["AuthenticationResult"]["AccessToken"];

        return $response;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getUser(): User
    {
        $endpoint = $this->config->getHost() . "user";

        $request = new Request("GET", $endpoint, [
            "Authorization" => "Bearer " . $this->token,
        ]);
        $response = $this->sendRequest($request);

        return UserBuilder::buildFromResponse(json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @throws ClientExceptionInterface
     */
    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }

    protected function isErrorCodePresent(string $code, array $errors): bool
    {
        return in_array($code, array_map(fn (array $error): string => $error["Code"], $errors), true);
    }
}
