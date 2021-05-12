<?php

declare(strict_types=1);

use Insly\Identifier\Client\Config;
use Insly\Identifier\Client\Exceptions\InvalidHostFormatException;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testHostWithoutSlashAtTheEnd(): void
    {
        $this->expectException(InvalidHostFormatException::class);
        new Config("https://example.com/api/v1", "tenant");
    }

    public function testHostWithSlashAtTheEnd(): void
    {
        $config = new Config("https://example.com/api/v1/", "tenant");
        $this->assertNotEmpty($config);
    }
}
