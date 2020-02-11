<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase\Tests;

use Exception;
use League\Container\Container;
use PHPUnit\Framework\TestCase;
use JustSteveKing\Suitcase\Client;
use GuzzleHttp\Client as HttpClient;

class ClientTest extends TestCase
{
    protected Client $sdk;

    protected function setUp(): void
    {
        $this->sdk = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com/'
        ]);
    }

    public function testClientCanBeCreated()
    {
        $this->assertInstanceOf(Client::class, $this->sdk);
    }

    public function testHttpClientCanBeAccessed()
    {
        $this->assertInstanceOf(HttpClient::class, $this->sdk->getHttpClient());
    }

    public function testCanAddASingleResource()
    {
        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $this->assertArrayHasKey('posts', $this->sdk->getResources());
    }

    public function testCanAddMultipleResources()
    {
        $posts = [
            'url' => 'posts'
        ];

        $users = [
            'url' => 'users'
        ];

        $this->sdk->add([
            'posts' => $posts,
            'users' => $users
        ]);

        $this->assertArrayHasKey('posts', $this->sdk->getResources());
        $this->assertArrayHasKey('users', $this->sdk->getResources());
    }

    public function testResourceCanBeSelected()
    {
        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $this->assertInstanceOf(Client::class, $this->sdk->posts);
    }

    public function testExceptionThrownOnInvalidResource()
    {
        $this->expectException(Exception::class);

        $this->assertInstanceOf(Client::class, $this->sdk->fake);
    }

    public function testEndpointCanBeConstructed()
    {
        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $this->sdk->posts->get('/');
    }
}
