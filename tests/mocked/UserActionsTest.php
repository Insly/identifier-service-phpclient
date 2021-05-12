<?php

declare(strict_types=1);

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Exceptions\NoTokenException;
use Insly\Identifier\Client\Exceptions\NoUserCustomDataException;
use Insly\Identifier\Client\Exceptions\TokenExpiredException;
use Insly\Identifier\Client\Testing\LoginMocks;
use Insly\Identifier\Client\Testing\UserMocks;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UserActionsTest extends TestCase
{
    protected Config $config;

    protected function setUp(): void
    {
        $this->config = new Config("https://example.com/api/v1/", "tenant");
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testRetrievingUserWithoutTokenProvided(): void
    {
        $client = new Client(new Guzzle(), $this->config);

        $this->expectException(NoTokenException::class);
        $client->getUser();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws NoTokenException
     */
    public function testRetrievingUserWithExpiredToken(): void
    {
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        $this->config->setToken($token);

        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = LoginMocks::getTokenExpiredResponse();
                return new Response(401, [], json_encode($response));
            }
        };

        $this->expectException(TokenExpiredException::class);
        $client->getUser();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws NoTokenException
     */
    public function testRetrievingUser(): void
    {
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        $this->config->setToken($token);

        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = UserMocks::getResponse();
                return new Response(200, [], json_encode($response));
            }
        };

        $user = $client->getUser();
        $this->assertSame("00000000-0000-0000-0000-000000000000", $user->getId());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws NoUserCustomDataException
     * @throws NoTokenException
     */
    public function testRetrievingUserWithCustomData(): void
    {
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        $this->config->setToken($token);

        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = UserMocks::getResponseWithCustomData();
                return new Response(200, [], json_encode($response));
            }
        };

        $user = $client->getUser();
        $this->assertSame("test", $user->getCustom("test"));
    }

    /**
     * @throws NoTokenException
     * @throws ClientExceptionInterface
     */
    public function testRetrievingUserWithNoCustomData(): void
    {
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        $this->config->setToken($token);

        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = UserMocks::getResponse();
                return new Response(200, [], json_encode($response));
            }
        };

        $user = $client->getUser();

        $value = $user->getCustom("test");
        $this->assertNull($value);
    }

    /**
     * @throws NoTokenException
     * @throws ClientExceptionInterface
     */
    public function testRetrievingUserWithNoRequiredCustomData(): void
    {
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        $this->config->setToken($token);

        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = UserMocks::getResponse();
                return new Response(200, [], json_encode($response));
            }
        };

        $user = $client->getUser();

        $this->expectException(NoUserCustomDataException::class);
        $user->getRequiredCustom("test");
    }
}
