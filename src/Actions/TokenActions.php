<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Actions;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Client;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;

/**
 * @mixin Client
 */
trait TokenActions
{
    /**
     * @throws ClientExceptionInterface
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
     * @throws ClientExceptionInterface
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
     * @throws ClientExceptionInterface
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
}
