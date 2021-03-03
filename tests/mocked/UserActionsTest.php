<?php

declare(strict_types=1);

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response;
use Insly\Identifier\Client\Clients\UserClient;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Exceptions\InvalidTenantException;
use Insly\Identifier\Client\Exceptions\NotAuthorizedException;
use Insly\Identifier\Client\Exceptions\NoTokenException;
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
        $this->config = new Config();
        $this->config->setUsername("username");
        $this->config->setPassword("password");
        $this->config->setTenant("tenant");
        $this->config->setHost("https://example.com/api/v1/");
    }

    /**
     * @throws ClientExceptionInterface
     * @throws InvalidTenantException
     * @throws NoTokenException
     * @throws NotAuthorizedException
     */
    public function testHappyPath(): void
    {
        $client = new class(new Guzzle(), $this->config) extends UserClient {
            protected string $flag = "";

            protected function sendRequest(RequestInterface $request): ResponseInterface
            {
                if ($this->flag === "login") {
                    $this->flag = "";
                    $response = LoginMocks::getResponse("eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9");
                    return new Response(200, [], json_encode($response));
                }

                $response = UserMocks::getResponse();
                return new Response(200, [], json_encode($response));
            }

            public function login(): ResponseInterface
            {
                $this->flag = "login";
                return parent::login();
            }
        };

        $user = $client->getUser();

        $this->assertSame("00000000-0000-0000-0000-000000000000", $user->getId());
    }
}
