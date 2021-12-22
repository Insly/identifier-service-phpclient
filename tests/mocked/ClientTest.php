<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Exceptions\ExtractResponseException;
use Insly\Identifier\Client\Testing\TestCase;

class ClientTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testHttpHeadersAreBuildCorrectlyWithEmptyToken(): void
    {
        $additionalHeaders = [
            "test" => "testValue",
            "example" => 123,
        ];
        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $buildHeadersMethod = $this->getProtectedMethod(Client::class, "buildHeaders");

        $preparedHeaders = $buildHeadersMethod->invokeArgs($client, [
            "headers" => $additionalHeaders,
        ]);

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
        $config = new Config("host", "tenant");
        $config->setToken("testToken");
        $client = new Client(new GuzzleClient(), $config);
        $buildHeadersMethod = $this->getProtectedMethod(Client::class, "buildHeaders");

        $preparedHeaders = $buildHeadersMethod->invoke($client);

        $expectedHeaders = [
            "Authorization" => "Bearer testToken",
        ];
        $this->assertHeaders($expectedHeaders, $preparedHeaders);
    }

    /**
     * @throws ReflectionException
     */
    public function testValidResponseIsExtractedCorrectly(): void
    {
        $validResponse = new Response(status: 200, body: json_encode([
            "test" => "value",
        ]));
        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $extractResponseMethod = $this->getProtectedMethod(Client::class, "extractResponse");

        $responseContent = $extractResponseMethod->invokeArgs($client, [
            "response" => $validResponse,
        ]);

        $this->assertIsArray($responseContent);
        $this->assertArrayHasKey("test", $responseContent);
    }

    /**
     * @throws ReflectionException
     */
    public function testProperExceptionIsThrownDuringResponseExtracting(): void
    {
        $this->expectException(ExtractResponseException::class);
        $this->expectExceptionMessage("An error occurred during retrieving response from the Identifier service.");

        $validResponse = new Response(status: 200, body: null);
        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $extractResponseMethod = $this->getProtectedMethod(Client::class, "extractResponse");

        $extractResponseMethod->invokeArgs($client, [
            "response" => $validResponse,
        ]);
    }

    protected function assertHeaders(array $expectedHeaders, array $preparedHeaders): void
    {
        foreach ($expectedHeaders as $headerName => $headerValue) {
            $this->assertArrayHasKey($headerName, $preparedHeaders);
            $this->assertSame($headerValue, $preparedHeaders[$headerName], "Expected value (${headerValue}) for header (${headerName}) is not the same as (${preparedHeaders[$headerName]})");
        }
    }
}
