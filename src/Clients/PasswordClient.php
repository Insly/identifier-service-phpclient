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
    public function reset(string $username, ?string $token = null): array
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "password/reset/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders(), [
            "username" => $username,
        ]);
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function update(string $confirmationCode, string $password, string $username, ?string $token = null): array
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "password/update/" . $this->config->getTenant();
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders(), [
            "confirmation_code" => $confirmationCode,
            "password" => $password,
            "username" => $username,
        ]);
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }
}
