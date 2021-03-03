# insly/identifier-service-phpclient

PHP client for Identifier HTTP interface

## Installation

## Usage

```php
<?php

declare(strict_types=1);

use GuzzleHttp\Client as Guzzle;
use Insly\Identifier\Client\Clients\UserClient;
use Insly\Identifier\Client\Config;

$config = new Config();
$config->setUsername("username");
$config->setPassword("password");
$config->setTenant("tenant");
$config->setHost("https://example.com/api/v1/");

$client = new UserClient(new Guzzle(), $config);
$client->getUser();
```

## Development

### Testing

#### Basic tests
There are multiple tests with mocked responses. You can run them with:
```
composer test
```

#### e2e tests
Project is equipped with a set of tests for the end to end testing. You can run them with:
```
composer e2e
```

You must remember about two mandatory conditions:
* you have to be connected via Insly VPN,
* you have to fill `.env` file basing on `.env.example` with all fields filled.