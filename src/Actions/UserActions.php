<?php

declare(strict_types=1);

namespace Insly\Identifier\Client\Actions;

use GuzzleHttp\Psr7\Request;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Entities\Builders\UserBuilder;
use Insly\Identifier\Client\Entities\User;
use Insly\Identifier\Client\Exceptions\ValidationExceptionContract;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\HttpFoundation\Request as RequestMethod;

/**
 * @mixin Client
 */
trait UserActions
{
    /**
     * @throws ValidationExceptionContract
     * @throws ClientExceptionInterface
     */
    public function getUser(): User
    {
        $endpoint = $this->config->getHost() . "user";
        $request = new Request(RequestMethod::METHOD_GET, $endpoint, $this->buildHeaders());

        $response = $this->sendRequest($request);
        return UserBuilder::buildFromResponse(json_decode($response->getBody()->getContents(), true));
    }
}
