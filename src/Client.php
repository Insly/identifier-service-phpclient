<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Exceptions\Handlers\InvalidTenant;
use Insly\Identifier\Client\Exceptions\Handlers\NotAuthorized;
use Insly\Identifier\Client\Exceptions\Handlers\ResponseExceptionHandler;
use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;
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
     * @throws ValidationExceptionContract
     */
    public function login(): ResponseInterface
    {
        $endpoint = $this->config->getHost() . "login/" . $this->config->getTenant();
        $credentials = [
            "username" => $this->config->getUsername(),
            "password" => $this->config->getPassword(),
        ];

        $request = new Request("POST", $endpoint, [], json_encode($credentials));
        $response = $this->sendRequest($request);
        $content = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() === Response::HTTP_BAD_REQUEST) {
            $handlers = [
                new NotAuthorized(),
                new InvalidTenant(),
            ];

            /** @var ResponseExceptionHandler $handler */
            foreach ($handlers as $handler) {
                $handler->validate($content["Errors"]);
            }
        }

        $this->token = $content["AuthenticationResult"]["AccessToken"];

        return $response;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function logout(): void
    {
        $endpoint = $this->config->getHost() . "logout";
        $request = new Request("GET", $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    protected function buildHeaders(...$headers): array
    {
        return [
            "Authorization" => "Bearer " . $this->token,
            ...$headers,
        ];
    }

    /**
     * @throws ClientExceptionInterface
     */
    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}
