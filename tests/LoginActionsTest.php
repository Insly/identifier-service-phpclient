<?php

declare(strict_types=1);

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Exceptions\InvalidTenantException;
use Insly\Identifier\Client\Exceptions\NotAuthorizedException;
use Insly\Identifier\Client\Testing\LoginMocks;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . "/../vendor/autoload.php";

class LoginActionsTest extends TestCase
{
    protected Config $config;

    protected function setUp(): void
    {
        $this->config = new Config();
        $this->config->setTenant("tenant");
        $this->config->setHost("https://example.com/api/v1/");
    }

    /**
     * @throws NotAuthorizedException
     * @throws ClientExceptionInterface
     */
    public function testProperAuthentication(): void
    {
        $client = new class(new Guzzle(), $this->config) extends Client {
            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                $response = LoginMocks::getResponse("test");
                return new Response(200, [], json_encode($response));
            }
        };

        $client->login("username", "password");
        $this->assertSame("test", $client->getAccessToken());
    }

    /**
     * @throws NotAuthorizedException
     * @throws ClientExceptionInterface
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
        $client->login("username", "password");
    }

    /**
     * @throws NotAuthorizedException
     * @throws ClientExceptionInterface
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

        $this->expectException(InvalidTenantException::class);
        $client->login("username", "password");
    }
}
