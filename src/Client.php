<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Entities\Builders\IdentifierErrorResponseBuilder;
use Insly\Identifier\Client\Entities\Builders\UserBuilder;
use Insly\Identifier\Client\Entities\User;
use Insly\Identifier\Client\Exceptions\ExtractResponseException;
use Insly\Identifier\Client\Exceptions\Handlers\IdentifierResponseHandler;
use Insly\Identifier\Client\Exceptions\IdentifierServiceClientException;
use Insly\Identifier\Client\Exceptions\NoTokenException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    protected string $token = "";

    public function __construct(
        protected ClientInterface $client,
        protected Config $config,
    ) {
        $this->token = $config->getToken();
    }

    public function getAccessToken(): string
    {
        return $this->token;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws IdentifierServiceClientException
     * @throws JsonException
     */
    public function login(): ResponseInterface
    {
        $endpoint = $this->config->getHost() . "login/" . $this->config->getTenant();
        $credentials = [
            "username" => $this->config->getUsername(),
            "password" => $this->config->getPassword(),
        ];

        $request = new Request(RequestMethod::METHOD_POST, $endpoint, [], json_encode($credentials, flags: JSON_THROW_ON_ERROR));
        $response = $this->sendRequest($request);
        $this->validateResponse($response);

        $content = $this->extractResponse($response);
        $this->token = $content["authentication_result"]["access_token"] ?? "";

        return $response;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws IdentifierServiceClientException
     * @throws JsonException
     * @throws NoTokenException
     */
    public function logout(): void
    {
        $this->validateToken();

        $endpoint = $this->config->getHost() . "logout";
        $request = new Request(RequestMethod::METHOD_GET, $endpoint, $this->buildHeaders());

        $response = $this->sendRequest($request);
        $this->validateResponse($response);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws IdentifierServiceClientException
     * @throws JsonException
     */
    public function client(string $id, string $secret, string $scope): array
    {
        $endpoint = $this->config->getHost() . "token/client/" . $this->config->getTenant();
        $request = new Request(
            RequestMethod::METHOD_POST,
            $endpoint,
            $this->buildHeaders(),
            json_encode(
                [
                    "client_id" => $id,
                    "client_secret" => $secret,
                    "scope" => $scope,
                ],
                flags: JSON_THROW_ON_ERROR,
            ),
        );
        $response = $this->sendRequest($request);
        $this->validateResponse($response);

        return $this->extractResponse($response);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws IdentifierServiceClientException
     * @throws JsonException
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
            ],
        );
        $response = $this->sendRequest($request);
        $this->validateResponse($response);

        return $this->extractResponse($response);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws IdentifierServiceClientException
     * @throws JsonException
     */
    public function validate(string $accessToken): array
    {
        $endpoint = $this->config->getHost() . "token/validate/" . $this->config->getTenant();
        $request = new Request(
            RequestMethod::METHOD_POST,
            $endpoint,
            $this->buildHeaders(),
            json_encode(
                [
                    "access_token" => $accessToken,
                ],
                flags: JSON_THROW_ON_ERROR,
            ),
        );
        $response = $this->sendRequest($request);
        $this->validateResponse($response);

        return $this->extractResponse($response);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws IdentifierServiceClientException
     * @throws JsonException
     * @throws NoTokenException
     */
    public function getUser(): User
    {
        $this->validateToken();

        $endpoint = $this->config->getHost() . "user/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_GET, $endpoint, $this->buildHeaders());

        $response = $this->sendRequest($request);
        $this->validateResponse($response);

        return UserBuilder::buildFromResponse($this->extractResponse($response));
    }

    protected function buildHeaders(array $headers = []): array
    {
        return array_merge(
            [
                "Authorization" => "Bearer " . $this->token,
            ],
            $headers,
        );
    }

    /**
     * @throws ClientExceptionInterface
     */
    protected function sendRequest(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }

    /**
     * @throws IdentifierServiceClientException
     * @throws ExtractResponseException
     * @throws JsonException
     */
    protected function validateResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $responseContent = $this->extractResponse($response);
            $identifierErrorResponse = IdentifierErrorResponseBuilder::fromResponseContent($responseContent, $response->getStatusCode());

            $responseHandler = new IdentifierResponseHandler();
            $responseHandler->handle($identifierErrorResponse);
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

    /**
     * @throws ExtractResponseException
     */
    protected function extractResponse(ResponseInterface $response): array
    {
        try {
            return json_decode($response->getBody()->getContents(), associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new ExtractResponseException(previous: $exception);
        }
    }
}
