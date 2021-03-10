# insly/identifier-service-phpclient

> PHP client for Identifier HTTP interface

## Installation

Add a custom repository to your `composer.json`:

```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:Insly/identifier-service-phpclient.git"
    }
],
```

or import via path if you've cloned the repository already:

```
"repositories": [
    {
        "type": "path",
        "url": "../identifier-service-phpclient"
    }
],
```

And then get a package via Composer:

``` 
composer require insly/identifier-service-phpclient
```

## Usage

### Basics

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

### Laravel

In Laravel application you may want to use any of clients via dependency injection. Then it comes handy to bind
implementation in the service provider:

```php
<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Insly\Identifier\Client\Clients\UserClient;
use Insly\Identifier\Client\Config;

class CognitoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserClient::class, function (): UserClient {
            $config = new Config();
            $config->setUsername(config("auth.cognito.username"));
            $config->setPassword(config("auth.cognito.password"));
            $config->setTenant(config("auth.cognito.tenant"));
            $config->setHost(config("auth.cognito.host"));

            return new UserClient(new Client(), $config);
        });
    }
}

```

with `config/auth.php` extended with:

```php
<?php

declare(strict_types=1);

return [
    // (...),
    "cognito" => [
        "username" => env("COGNITO_USERNAME"),
        "password" => env("COGNITO_PASSWORD"),
        "tenant" => env("COGNITO_TENANT_TAG"),
        "host" => env("COGNITO_HOST"),
    ],
]
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