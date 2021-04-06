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
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;

$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";

$config = new Config("https://example.com/api/v1/", "tenant");
$config->setToken($token);

$client = new Client(new Guzzle(), $config);
$client->getUser();
```

### Laravel

In Laravel application you may want to use any of clients via dependency injection. Then it comes handy to bind
implementation in the service provider:

```php
<?php

declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\ServiceProvider;
use Insly\Identifier\Client\Client;
use Insly\Identifier\Client\Config;

class CognitoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Client::class, function (): Client {
            $config = new Config("https://example.com/api/v1/", "tenant");
            $config->setToken(config("auth.cognito.token"));

            return new Client(new Guzzle(), $config);
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
        "host" => env("COGNITO_HOST"),
        "tenant" => env("COGNITO_TENANT_TAG"),
        "token" => env("COGNITO_TOKEN"),
        "username" => env("COGNITO_USERNAME"),
        "password" => env("COGNITO_PASSWORD"),
    ],
];
```

and `.env` file with:
```
COGNITO_HOST=
COGNITO_TENANT_TAG=
COGNITO_TOKEN=
COGNITO_USERNAME=
COGNITO_PASSWORD=
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
