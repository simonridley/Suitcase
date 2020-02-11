# JustSteveKing Suitcase

The aim of this library is to enable you to connect your APIs more fluently, by providing a base level SDK for you to work with.

## API Blueprint

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$sdk = new JustSteveKing\Suitcase\Client();

$sdk->build([
    // an array of class based resources
]);

$sdk->add(
    // class resource
);

$sdk->add([
    // an array of class
])

```

## Special Thanks

- [The PHP League](https://thephpleague.com/) for their Container package