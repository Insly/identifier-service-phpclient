<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Testing\TestCase;

class ClientTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testHttpHeadersAreBuildCorrectlyWithEmptyToken(): void
    {
        // given
        $additionalHeaders = [
            "test" => "testValue",
            "example" => 123,
        ];

        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $method = $this->getProtectedMethod(Client::class, "buildHeaders");

        // when
        $preparedHeaders = $method->invokeArgs($client, ["headers" => $additionalHeaders]);

        // then
        $expectedHeaders = [
            "Authorization" => "Bearer ",
            "test" => "testValue",
            "example" => 123,
        ];

        $this->assertHeaders($expectedHeaders, $preparedHeaders);
    }

    /**
     * @throws ReflectionException
     */
    public function testHttpHeadersAreBuildCorrectlyWithProvidedToken(): void
    {
        // given
        $config = new Config("host", "tenant");
        $config->setToken("testToken");

        $client = new Client(new GuzzleClient(), $config);
        $method = $this->getProtectedMethod(Client::class, "buildHeaders");

        // when
        $preparedHeaders = $method->invoke($client);

        // then
        $expectedHeaders = [
            "Authorization" => "Bearer testToken",
        ];

        $this->assertHeaders($expectedHeaders, $preparedHeaders);
    }

    protected function assertHeaders(array $expectedHeaders, array $preparedHeaders): void
    {
        foreach ($expectedHeaders as $headerName => $headerValue) {
            $this->assertArrayHasKey($headerName, $preparedHeaders);
            $this->assertEquals($headerValue, $preparedHeaders[$headerName], "Expected value (${headerValue}) for header (${headerName}) is not equal with (${preparedHeaders[$headerName]})");
        }
    }
}
