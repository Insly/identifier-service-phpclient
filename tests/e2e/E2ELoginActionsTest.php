<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class E2ELoginActionsTest extends TestCase
{
    protected Config $config;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        $this->config = new Config($_ENV["HOST"], $_ENV["TENANT_TAG"]);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function testSomething(): void
    {
        $client = new Client(new Guzzle(), $this->config);
        $client->login();
    }
}
