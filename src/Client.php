<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Entities\Builders\UserBuilder;
use Insly\Identifier\Client\Entities\User;
use Insly\Identifier\Client\Exceptions\Handlers\HeaderTokenExpired;
use Insly\Identifier\Client\Exceptions\Handlers\NotAuthorized;
use Insly\Identifier\Client\Exceptions\Handlers\ResponseExceptionHandler;
use Insly\Identifier\Client\Exceptions\Handlers\TokenExpired;
use Insly\Identifier\Client\Exceptions\Handlers\UnknownError;
use Insly\Identifier\Client\Exceptions\NoTokenException;
use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    /** @var ClientInterface */
    protected $client;
    /** @var Config */
    protected $config;
    /** @var string */
    protected $token = "";

    public function __construct(ClientInterface $client, Config $config)
    {
        $this->client = $client;
        $this->config = $config;
        $this->token = $config->getToken();
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }

    /**
     * @throws GuzzleException
     * @throws ValidationExceptionContract
     */
    public function login(): ResponseInterface
    {
        $endpoint = $this->config->getHost() . "login/" . $this->config->getTenant();
        $credentials = [
            "username" => $this->config->getUsername(),
            "password" => $this->config->getPassword(),
        ];

        $request = new Request(RequestMethod::METHOD_POST, $endpoint, [], json_encode($credentials));
        $response = $this->sendRequest($request);
        $this->validateResponse($response, [new NotAuthorized()]);

        $content = json_decode($response->getBody()->getContents(), true);
        $this->token = $content["authentication_result"]["access_token"] ?? "";

        return $response;
    }

    /**
     * @throws GuzzleException
     * @throws NoTokenException
     */
    public function logout(): void
    {
        $this->validateToken();

        $endpoint = $this->config->getHost() . "logout";
        $request = new Request(RequestMethod::METHOD_GET, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    /**
     * @throws GuzzleException
     */
    public function client(string $id, string $secret, string $scope): array
    {
        $endpoint = $this->config->getHost() . "token/client/" . $this->config->getTenant();
        $request = new Request(
            RequestMethod::METHOD_POST,
            $endpoint,
            $this->buildHeaders(),
            [
                "client_id" => $id,
                "client_secret" => $secret,
                "scope" => $scope,
            ]
        );
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function refresh(string $refreshToken, string $username): array
    {
        $endpoint = $this->config->getHost() . "token/refresh/" . $this->config->getTenant();
        $request = new Request(
            RequestMethod::METHOD_POST,
            $endpoint,
            $this->buildHeaders(),
            [
                "refresh_token" => $refreshToken,
                "username" => $username,
            ]
        );
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function validate(string $accessToken): array
    {
        $endpoint = $this->config->getHost() . "token/validate/" . $this->config->getTenant();
        $request = new Request(
            RequestMethod::METHOD_POST,
            $endpoint,
            $this->buildHeaders(),
            [
                "access_token" => $accessToken,
            ]
        );
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ValidationExceptionContract
     * @throws GuzzleException
     * @throws NoTokenException
     */
    public function getUser(): User
    {
        $this->validateToken();

        $endpoint = $this->config->getHost() . "user";
        $request = new Request(RequestMethod::METHOD_GET, $endpoint, $this->buildHeaders());

        $response = $this->sendRequest($request);
        $this->validateResponse($response);

        return UserBuilder::buildFromResponse(json_decode($response->getBody()->getContents(), true));
    }

    protected function buildHeaders(string ...$headers): array
    {
        return array_merge(
            [
                "Authorization" => "Bearer " . $this->token,
            ],
            $headers
        );
    }

    /**
     * @throws GuzzleException
     */
    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->send($request);
    }

    protected function validateResponse(ResponseInterface $response, array $handlers = []): void
    {
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $content = json_decode($response->getBody()->getContents(), true);

            $handlers = array_merge(
                [
                    new HeaderTokenExpired(),
                    new TokenExpired(),
                    new UnknownError(),
                ],
                $handlers
            );

            /** @var ResponseExceptionHandler $handler */
            foreach ($handlers as $handler) {
                $handler->validate($content["errors"]);
            }
        }
    }

    /**
     * @throws NoTokenException
     */
    protected function validateToken(): void
    {
        if (empty($this->token)) {
            throw new NoTokenException();
        }
    }
}
