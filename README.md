# e-satisfaction Http Package

[![Build Status](https://travis-ci.org/esatisfaction/esat-php.svg?branch=v1.0)](https://travis-ci.org/esatisfaction/esat-php)
[![Latest Stable Version](https://poser.pugx.org/esatisfaction/esat-php/v/stable?format=flat-square)](https://packagist.org/packages/esatisfaction/esat-php)
[![Total Downloads](https://poser.pugx.org/esatisfaction/esat-php/downloads?format=flat-square)](https://packagist.org/packages/esatisfaction/esat-php)
[![License](https://poser.pugx.org/esatisfaction/esat-php/license?format=flat-square)](https://packagist.org/packages/esatisfaction/esat-php)

e-satisfaction Http Package for handling all http request from php.

## Requirements

PHP 7.1.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require esatisfaction/esat-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/esatisfaction/esat-php/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once('/path/to/esatisfaction-php/init.php');
```

## Dependencies

This library require the following extensions and packages in order to work properly:

- [`panda/config`](https://packagist.org/packages/panda/config)
- [`panda/helpers`](https://packagist.org/packages/panda/helpers)
- [`ramsey/uuid`](https://packagist.org/packages/ramsey/uuid)
- [`symfony/http-foundation`](https://packagist.org/packages/symfony/http-foundation)
- [`monolog/monolog`](https://packagist.org/packages/monolog/monolog)
- [`php-http/guzzle6-adapter`](https://packagist.org/packages/php-http/guzzle6-adapter)
- [`esatisfaction/http`](https://packagist.org/packages/esatisfaction/http)
- [`symfony/cache`](https://packagist.org/packages/symfony/cache)

If you use Composer, these dependencies should be handled automatically.
If you install manually, you'll want to make sure that these extensions are available and loaded.
 
## How do I start working with services?

To start working with the SDK, you have to initialize the following:

* Setup the main Esat Registry
* Set the Authorization Scheme to be used by each service's HttpClient

Example:

```php
use \Esat\Esat;
use \Esat\Auth\TokenAuthProvider;
use \Esat\Services\Questionnaires\Questionnaire;
use \Monolog\Logger;

// Initialize main Esatisfaction and Authentication
$esat = new Esat();
$tokenAuthProvider = new TokenAuthProvider('YOUR_TOKEN');
$httpClient = new AuthProviderInterface($tokenAuthProvider);

// Create Questionnaire Service
$questionnaire = new Questionnaire($esat, new Logger(), $httpClient);

// Work with Service
$questionnaire->load(/* Your arguments */);
```

## Code of Conduct Guidelines

Take a look at the [Code of Conduct](CODE_OF_CONDUCT.md) document.
