# JustSteveKing Suitcase

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

**Work In Progress**

The aim of this library is to enable you to connect your APIs more fluently, by providing a base level SDK for you to work with.

## Install

Via Composer

```bash
$ composer require juststeveking/suitcase
```

### Setting up your SDK

```php
$sdk = new JustSteveKing\Suitcase\Client([
    'base_uri' => 'https://jsonplaceholder.typicode.com'
]);
```

### Adding Resources to your SDK

```php
$sdk->add([
    'posts' => [
        'url' => 'posts'
    ]
])
```

### Managing Headers

You can set default headers in the initial construction of the `Client` class:

```php
$sdk = new JustSteveKing\Suitcase\Client([
    'base_uri' => 'https://jsonplaceholder.typicode.com',
    'headers' => [
        'foo' => 'bar'
    ]
]);
```

Or add then programatically:

```php
$sdk->setHeaders([
    'foo' => 'bar'
]);
```

When you use the `setHeaders` method, this performs an `array_merge` on the default headers passed through in construction, allowing the most flexibility


### Get a Resource

```php
$sdk->posts->get(1);
```

### Listing all Resources

```php
$sdk->posts->list();
```

### Create a Resource

```php
$sdk->posts->create([
    'title' => 'Test Title',
    'description' => 'Test description',
    'userId' => 1
]);
```

### Update a Resource

```php
$sdk->posts->update(
    1,
    [
        'title' => 'Updated Tittle'
    ],
    'PATCH' // An optional parameter to override the default PUT request
);
```

### Delete a Resource

```php
$sdk->posts->delete(1);
```

### There are methods available to programatically add filters to your query

```php
$sdk->addFilters([
    'userId' => 1
]);
$sdk->posts->list();
```

## Still to do

- Sub Resources and inlcudes
- Sorting
- Cleaner and nicer filtering
- Access control on resources




[ico-version]: https://img.shields.io/packagist/v/juststeveking/suitcase.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/JustSteveKing/Suitcase.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/JustSteveKing/Suitcase.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/juststeveking/suitcase.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/juststeveking/suitcase
[link-scrutinizer]: https://scrutinizer-ci.com/g/JustSteveKing/Suitcase/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/JustSteveKing/Suitcase/
[link-downloads]: https://packagist.org/packages/juststeveking/suitcase
[link-author]: https://github.com/JustSteveKing
