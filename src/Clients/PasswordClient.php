<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Clients;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Client;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;

class PasswordClient extends Client
{
    /**
     * @throws ClientExceptionInterface
     */
    public function reset(): void
    {
        $endpoint = $this->config->getHost() . "password/reset/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function update(): void
    {
        $endpoint = $this->config->getHost() . "password/update/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }
}
