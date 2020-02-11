# JustSteveKing Suitcase

*Work In Progress*

The aim of this library is to enable you to connect your APIs more fluently, by providing a base level SDK for you to work with.

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$sdk = new JustSteveKing\Suitcase\Client([
    'base_uri' => 'https://your.api.com'
]);

$sdk->add([
    'resource' => [
        'url' => 'resource'
    ]
]);

```