<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Clients;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Client;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;

class TokenClient extends Client
{
    /**
     * @throws ClientExceptionInterface
     */
    public function client(?string $token = null): void
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "token/client/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function refresh(?string $token = null): void
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "token/refresh/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function update(?string $token = null): void
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "token/update/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }
}
