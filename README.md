# JustSteveKing Suitcase

*Work In Progress*

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
```

### Adding Resources to your SDK

```php
$sdk->add([
    'posts' => [
        'url' => 'posts'
    ]
])
```

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
