<?php

declare(strict_types=1);

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Exceptions\ExtractResponseException;
use Insly\Identifier\Client\Exceptions\IdentifierService\NotAuthorizedException;
use Insly\Identifier\Client\Exceptions\IdentifierService\UndefinedErrorException;
use Insly\Identifier\Client\Testing\LoginMocks;
use Insly\Identifier\Client\Testing\RequestMocks;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LoginActionsTest extends TestCase
{
    protected Config $config;

    protected function setUp(): void
    {
        $this->config = new Config("https://example.com/api/v1/", "tenant");
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws JsonException
     */
    public function testProperAuthentication(): void
    {
        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = LoginMocks::getResponse("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9");
                return new Response(200, [], json_encode($response));
            }
        };

        $client->login();
        $this->assertSame("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9", $client->getAccessToken());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws JsonException
     */
    public function testProperAuthenticationWithPassword(): void
    {
        $requestHistory = [];
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(LoginMocks::getResponse("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9"))),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($requestHistory));

        $client = new Client(new Guzzle([
            "handler" => $handlerStack,
        ]), $this->config);
        $client->loginWithPassword("foo-user", "foo-password", [
            "foo" => "foo-meta",
        ]);

        $this->assertCount(1, $requestHistory);
        $this->assertJsonStringEqualsJsonString(
            json_encode(RequestMocks::getLogin("foo-user", "foo-password", [
                "foo" => "foo-meta",
            ])),
            $requestHistory[0]["request"]->getBody()->getContents(),
        );
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExtractResponseException
     * @throws JsonException
     */
    public function testFailedByInvalidCredentialsAuthentication(): void
    {
        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = LoginMocks::getInvalidUsernameOrPasswordResponse();
                return new Response(400, [], json_encode($response));
            }
        };

        $this->expectException(NotAuthorizedException::class);
        $client->login();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws ExtractResponseException
     */
    public function testFailedByInvalidTenantAuthentication(): void
    {
        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = LoginMocks::getInvalidTenantResponse();
                return new Response(400, [], json_encode($response));
            }
        };

        $this->expectException(UndefinedErrorException::class);
        $client->login();
    }
}
