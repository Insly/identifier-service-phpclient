<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Clients;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Client;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;

class MFAClient extends Client
{
    /**
     * @throws ClientExceptionInterface
     */
    public function disable(string $accessToken, ?string $token = null): array
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "mfa/totp/disable";
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders(), [
            "access_token" => $accessToken,
        ]);
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function enable(string $accessToken, string $qrCodeLabel, string $session, ?string $token = null): array
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "mfa/totp/enable";
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders(), [
            "access_token" => $accessToken,
            "qr_code_label" => $qrCodeLabel,
            "session" => $session,
        ]);
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function verify(string $accessToken, string $userCode, string $session, ?string $token = null): array
    {
        $this->authenticate($token);

        $endpoint = $this->config->getHost() . "mfa/totp/verify";
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders(), [
            "access_token" => $accessToken,
            "session" => $session,
            "user_code" => $userCode,
        ]);
        $response = $this->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }
}
