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
            
            $authorizationHeader = $request?->header("Authorization") ?? "";
            $token = str_replace("Bearer ", "", $authorizationHeader);
            $config->setToken($token);

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

### Run

```bash
cp .env.example .env

make build
make run

# enter container shell
make shell

# stop container
make stop
```

If you don't have `make`, then check _Makefile_ for used commands.

### Testing

#### Basic tests

There are multiple tests with mocked responses. You can run them with:


```bash
# Tests will run in the new container specified in docker-compose (php service):
make test
```
or inside container
```bash
composer test
```

#### Test with specific PHP version

If you want to run tests with specific PHP version, just run:
```bash
# Tests will run in new container
make test-php-version
```
The default version is `8.0` - defined in the Makefile. You can define other version in `.env` file, just add: e.g. `TESTS_PHP_VERSION=7.2`\
You can also specify `APP_DIR` in `.env` file, which is used in _test-php-version_ command.\
Otherwise, default value defined in the Makefile will be used.