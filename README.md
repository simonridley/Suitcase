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

$sdk->resource->list(); // List Resources
$sdk->resource->get(1); // Get a Resource
$sdk->resource->create([
    // data
]); // Create a new Resource
$sdk->resource->update(
    1, //identifier
    [], // data to update
    'PUT', // Optional method to override as PATCH Request
); // Update a Resource
$sdk->resource->delete(1); // Delete a Resource

/**
 *  Adding filters to your query
 */
$sdk->addFilters([
    'user_id' => 1
]);

```