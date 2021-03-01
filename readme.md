# insly/identifier-service-phpclient

PHP client for Identifier HTTP interface

## Installation

## Usage

```php
<?php

declare(strict_types=1);

use GuzzleHttp\Client as Guzzle;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;

$config = new Config();
$config->setTenant("tenant");
$config->setHost("https://example.com/api/v1/");

$client = new Client(new Guzzle(), $config);
$client->login("username", "password");
$client->getUser();
```

## Development
