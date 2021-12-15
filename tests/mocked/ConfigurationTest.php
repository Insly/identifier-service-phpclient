<?php

declare(strict_types=1);

use Insly\Identifier\Client\Config;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testHostWithoutSlashAtTheEnd(): void
    {
        $config = new Config("https://example.com/api/v1", "tenant");
        $this->assertStringEndsWith("v1/", $config->getHost());
    }

    public function testHostWithSlashAtTheEnd(): void
    {
        $config = new Config("https://example.com/api/v1/", "tenant");
        $this->assertStringEndsWith("v1/", $config->getHost());
    }
}
