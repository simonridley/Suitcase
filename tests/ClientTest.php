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

    protected function buildClient()
    {
        $this->sdk = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com/'
        ]);
    }

    protected function setUp(): void
    {
        $this->buildClient();
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

    public function testCanRunAGetRequestForAllResources()
    {
        $this->buildClient();

        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $response = $this->sdk->posts->list();

        $this->assertTrue(is_array($response));
    }

    public function testCanRunAGetRequestForASingleResource()
    {
        $this->buildClient();

        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $response = $this->sdk->posts->get(1);

        $this->assertEquals(
            $response->title,
            "sunt aut facere repellat provident occaecati excepturi optio reprehenderit"
        );

        $this->assertEquals(
            $response->id,
            1
        );
    }

    public function testCanCreateAResource()
    {
        $this->buildClient();

        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $response = $this->sdk->posts->create($item = [
            'title' => 'Test Title',
            'body' => 'Test body',
            'userId' => 1
        ]);

        $this->assertNotNull($response);
    }

    public function testCanUpdateAResource()
    {
        $this->buildClient();

        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $response = $this->sdk->posts->update(1, $item = [
            'title' => 'Test Title'
        ]);

        $this->assertNotNull($response);
    }

    public function testCanDeleteAResource()
    {
        $this->buildClient();

        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $response = $this->sdk->posts->delete(1);

        $this->assertNotNull($response);
    }

    public function testFiltersCanBeBuilt()
    {
        $this->buildClient();

        $this->sdk->addFilters([
            'userId' => 1
        ]);

        $this->assertArrayHasKey('userId', $this->sdk->getFilters());
    }

    public function testFiliterStringCanBeCreated()
    {
        $this->buildClient();

        $this->sdk->addFilters([
            'userId' => 1
        ]);

        $this->assertEquals(
            "userId=1",
            $this->sdk->buildFilters()
        );
    }

    public function testCanRunAGetRequestForResourcesWiithFilters()
    {
        $this->buildClient();
        
        $posts = [
            'url' => 'posts'
        ];

        $this->sdk->add([
            'posts' => $posts
        ]);

        $this->sdk->addFilters([
            'userId' => 1
        ]);

        $response = $this->sdk->posts->list();

        $this->assertTrue(is_array($response));
    }
}
