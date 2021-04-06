<?php

declare(strict_types=1);

namespace Insly\Identifier\Client;

use Insly\Identifier\Client\Actions\AuthActions;
use Insly\Identifier\Client\Actions\TokenActions;
use Insly\Identifier\Client\Actions\UserActions;
use Insly\Identifier\Client\Exceptions\NoTokenException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    use AuthActions;
    use TokenActions;
    use UserActions;

    protected ClientInterface $client;
    protected Config $config;
    protected string $token = "";

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

    protected function buildHeaders(string ...$headers): array
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
