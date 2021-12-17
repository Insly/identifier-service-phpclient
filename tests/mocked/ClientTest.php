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
        // given
        $additionalHeaders = [
            "test" => "testValue",
            "example" => 123,
        ];

        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $buildHeadersMethod = $this->getProtectedMethod(Client::class, "buildHeaders");

        // when
        $preparedHeaders = $buildHeadersMethod->invokeArgs($client, ["headers" => $additionalHeaders]);

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
        $buildHeadersMethod = $this->getProtectedMethod(Client::class, "buildHeaders");

        // when
        $preparedHeaders = $buildHeadersMethod->invoke($client);

        // then
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
        // given
        $validResponse = new Response(status: 200, body: json_encode(["test" => "value"]));

        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $extractResponseMethod = $this->getProtectedMethod(Client::class, "extractResponse");

        // when
        $responseContent = $extractResponseMethod->invokeArgs($client, ["response" => $validResponse]);

        // then
        $this->assertIsArray($responseContent);
        $this->assertArrayHasKey("test", $responseContent);
    }

    /**
     * @throws ReflectionException
     */
    public function testProperExceptionIsThrownDuringResponseExtracting(): void
    {
        // given
        $validResponse = new Response(status: 200, body: null);

        $client = new Client(new GuzzleClient(), new Config("host", "tenant"));
        $extractResponseMethod = $this->getProtectedMethod(Client::class, "extractResponse");

        // then
        $this->expectException(ExtractResponseException::class);
        $this->expectExceptionMessage("An error occurred during retrieving response from the Identifier service.");

        // when
        $extractResponseMethod->invokeArgs($client, ["response" => $validResponse]);
    }

    protected function assertHeaders(array $expectedHeaders, array $preparedHeaders): void
    {
        foreach ($expectedHeaders as $headerName => $headerValue) {
            $this->assertArrayHasKey($headerName, $preparedHeaders);
            $this->assertEquals($headerValue, $preparedHeaders[$headerName], "Expected value (${headerValue}) for header (${headerName}) is not equal with (${preparedHeaders[$headerName]})");
        }
    }
}
