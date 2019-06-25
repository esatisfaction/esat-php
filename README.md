# e-satisfaction Http Package

[![Build Status](https://travis-ci.org/esatisfaction/esat-php.svg?branch=v1.0)](https://travis-ci.org/esatisfaction/esat-php)
[![Latest Stable Version](https://poser.pugx.org/esatisfaction/esat-php/v/stable?format=flat-square)](https://packagist.org/packages/esatisfaction/esat-php)
[![Total Downloads](https://poser.pugx.org/esatisfaction/esat-php/downloads?format=flat-square)](https://packagist.org/packages/esatisfaction/esat-php)
[![License](https://poser.pugx.org/esatisfaction/esat-php/license?format=flat-square)](https://packagist.org/packages/esatisfaction/esat-php)

PHP library for the e-satisfaction API

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
use \Esat\Http\AuthClient;
use \Monolog\Logger;

// Initialize Authentication
$tokenAuthProvider = new TokenAuthProvider('YOUR_TOKEN', 'YOUR_DOMAIN');
$httpClient = new AuthClient($tokenAuthProvider);

// Initialize main Esatisfaction Registry
$esatRegistry = new Esat();
```

### Questionnaires

Read your questionnaires:

```php
use \Esat\Services\Questionnaires\Questionnaire;
use \Esat\Support\Model\Propel\FilterCriteria;
use \Esat\Support\Model\Propel\Pagination;
use \Monolog\Logger;

// Create Questionnaire Service
$questionnaire = new Questionnaire($esatRegistry, new Logger(), $httpClient);

// Load all questionnaires for my application
$applicationId = '123';
$filterCriteria = (new FilterCriteria())->equal('OwnerApplicationId', $applicationId);
$pagination = (new Pagination())->setMaxPerPage(25)->setPage(1);
$questionnairePager = $questionnaire->getList($filterCriteria, null, $pagination);

// Read all questionnaires
foreach ($questionnairePager->getQuestionnaires() as $questionnaireItem) {
    // Get questionnaire display name
    echo $questionnaireItem->getDisplayName();
}

// Load a questionnaire by id
if ($questionnaire->load('456sdfa')) {
    // Access questionnaire data
    $questionnaireModel = $questionnaire->getQuestionnaire();
    echo $questionnaireModel->getDisplayName();
}
```

### Questionnaire Instances

Create a questionnaire instance and send the link to your customers:

```php
use \Esat\Services\Questionnaires\Instances\Questionnaire;
use \Monolog\Logger;

// Create Questionnaire Service
$questionnaire = new Questionnaire($esatRegistry, new Logger(), $httpClient);

// Create questionnaire instance, with metadata
$responderMetadata = [
    'email' => 'john@doe.com',
    'gender' => 'male'
];
$questionnaireMetadata = [
    'transaction_id' => '12345asd',
    'transaction_date' => '2019-05-03 14:12'
];
if ($questionnaire->create('YOUR_QUESTIONNAIRE_ID', [], $questionnaireMetadata, $responderMetadata)) {
    // Get questionnaire collection url
    $collectionUrl = $questionnaire->getQuestionnaire()->getCollectionUrl();
    
    // Send your email with the above url
}
```

Read, Update or Delete Questionnaire Instances:

**NOTICE**: This will cause data deletion and might alter your data. It will not affect your credits as the credits are reduced on questionnaire submit.

```php
use \Esat\Services\Questionnaires\Instances\Questionnaire;
use \Monolog\Logger;

// Create Questionnaire Service
$questionnaire = new Questionnaire($esatRegistry, new Logger(), $httpClient);

// Load a questionnaire instance
// We always have to load the instance before performing an update or delete operation
$instanceId = 'sadfewf2134d';
if (!$questionnaire->load($instanceId)) {
    // Handle error
    echo 'Questionnaire instance Not Found';
    die;
}

// Update the questionnaire instance
$questionnaire->getQuestionnaire()->setLocale('el');
$questionnaire->getQuestionnaire()->setValidDayes(50);
if (!$questionnaire->update()) {
    // Handle error
    echo 'Questionnaire instance failed to be updated';
    die;
}

// Load another questionnaire instance to delete
// We always have to load the instance before performing an update or delete operation
$instanceId = '23rteg34';
if (!$questionnaire->load($instanceId)) {
    // Handle error
    echo 'Questionnaire instance Not Found';
    die;
}

// Delete the questionnaire instance
if (!$questionnaire->delete()) {
    // Handle error
    echo 'Questionnaire instance failed to be deleted';
    die;
}
```

### Pipelines

Read your pipelines:

```php
use \Esat\Services\Questionnaires\Pipeline;
use \Monolog\Logger;

// Create Pipeline Service
$pipeline = new Pipeline($esatRegistry, new Logger(), $httpClient);

// Get all pipelines for a given questionnaire id
$questionnaireId = 'asdf34rtefdfwe';
$pipelines = $pipeline->getList($questionnaireId);

// Read all pipelines
foreach ($pipelines as $pipelineItem) {
    // Get pipeline title
    echo $pipelineItem->getTitle();
}

// Load a pipeline by id
if ($pipeline->load('345uyjhg')) {
    // Access pipeline data
    $pipelineModel = $pipeline->getPipeline();
    echo $pipelineModel->getTitle();
}
```

### Queue Items

Add a queue item to allow e-satisfaction to send a survey:

```php
use \Esat\Services\Questionnaires\Pipelines\Queue;
use \Monolog\Logger;

// Create Queue Service
$queue = new Queue($esatRegistry, new Logger(), $httpClient);

// Prepare queue item parameters
$questionnaireId = 'asdf34rtefdfwe';
$pipelineId = 'a09uherwgfd';
$parameters = [
    'responder_channel_identifier' => 'john@doe.com',
    'send_time' => '2019-05-02 12:32',
];

// Create queue item
if (!$queue->create($questionnaireId, $pipelineId, $parameters)) {
    // Handle error
    echo 'Queue item failed to be created. Error: ' . $queue->getErrorFromLastResponse();
    die;
}
```

Read, Update or Delete Queue Items:

```php
use \Esat\Services\Questionnaires\Pipelines\Queue;
use \Monolog\Logger;

// Create Queue Service
$queue = new Queue($esatRegistry, new Logger(), $httpClient);

// Load a queue item
// We always have to load the item before performing an update or delete operation
$itemId = '9867w4wqrefd';
if (!$queue->load($itemId)) {
    // Handle error
    echo 'Queue item Not Found';
    die;
}

// Update the queue item
$queue->getQueueItem()->setLocale('el');
$queue->getQueueItem()->setSendTime('2019-06-03 14:32');
if (!$queue->update()) {
    // Handle error
    echo 'Queue item failed to be updated';
    die;
}

// Load another queue item to delete
// We always have to load the item before performing an update or delete operation
$itemId = '234rweg34';
if (!$queue->load($itemId)) {
    // Handle error
    echo 'Queue item Not Found';
    die;
}

// Delete the queue item
if (!$queue->delete()) {
    // Handle error
    echo 'Queue item failed to be deleted';
    die;
}
```

### Handling Errors

Each request stores the last response so that you can access it and get messages in case of errors.

```php
use \Esat\Services\Questionnaires\Questionnaire;
use \Monolog\Logger;

// Create Questionnaire Service
$questionnaire = new Questionnaire($esatRegistry, new Logger(), $httpClient);

// Load a questionnaire by id
if ($questionnaire->load('456sdfa')) {
    // Access questionnaire data
    $questionnaireModel = $questionnaire->getQuestionnaire();
} else {
    // Handle the error, get the http response code and error message, if any
    $error = '';
    switch ($questionnaire->getLastResponse()->getStatusCode()) {
        case 500:
            $error = 'An unexpected error occurred';
            break;
        case 404:
            $error = 'Questionnaire Not Found';
            break;
        default:
            $error = $questionnaire->getErrorFromLastResponse();
    }
    
    // Display error
    echo $error;
}
```

### Caching

This library is using a default runtime caching mechanism that reduces API calls during runtime.

The caching mechanism is on service level and works only on READ requests and is being reset when a POST or PATCH method is called on the same service.

If you are trying to READ the same resource twice without any updates in between, the service will hit the cache and get the same result.
You can override the cache by calling `setCacheEnabled(false)` on the service before calling the method.

Examples:

```php
use \Esat\Services\Questionnaires\Questionnaire;
use \Monolog\Logger;

// Create Questionnaire Service
$questionnaire = new Questionnaire($esat, new Logger(), $httpClient);

// DOES NOT hit cache
if ($questionnaire->load('456sdfa')) {
    // Access questionnaire data
    $questionnaireModel = $questionnaire->getQuestionnaire();
}

// DOES hit cache
if ($questionnaire->load('456sdfa')) {
    // Access questionnaire data
    $questionnaireModel = $questionnaire->getQuestionnaire();
}

// SKIP cache. From now on, all requests will skip cache.
$questionnaire->setCacheEnabled(false);
if ($questionnaire->load('456sdfa')) {
    // Access questionnaire data
    $questionnaireModel = $questionnaire->getQuestionnaire();
}

// Enable cache again to restore initial behavior. The following will DO hit cache
$questionnaire->setCacheEnabled(true);
if ($questionnaire->load('456sdfa')) {
    // Access questionnaire data
    $questionnaireModel = $questionnaire->getQuestionnaire();
}
```

## Feedback

This is an open-source library for calling e-satisfaction API.

Feel free to open Issues and Pull Requests to update it or fix bugs that you might find.

## Code of Conduct Guidelines

Take a look at the [Code of Conduct](CODE_OF_CONDUCT.md) document.
