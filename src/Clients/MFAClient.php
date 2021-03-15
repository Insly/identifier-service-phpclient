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
    public function disable(): void
    {
        $endpoint = $this->config->getHost() . "mfa/totp/disable";
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function enable(): void
    {
        $endpoint = $this->config->getHost() . "mfa/totp/enable";
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function verify(): void
    {
        $endpoint = $this->config->getHost() . "mfa/totp/verify";
        $request = new Request(RequestMethod::METHOD_POST, $endpoint, $this->buildHeaders());
        $this->sendRequest($request);
    }
}
