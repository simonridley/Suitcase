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

    protected function buildClient(array $headers = [])
    {
        $this->sdk = new Client([
            'base_uri' => 'https://jsonplaceholder.typicode.com/',
            'headers' => $headers
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

    public function testHeadersCanBeFetched()
    {
        $this->assertTrue(is_array($this->sdk->getHeaders()));

        $headers = [
            'foo' => 'bar'
        ];

        $this->buildClient($headers);

        $this->assertEquals($headers, $this->sdk->getHeaders());
    }

    public function testHeadersCanBeSet()
    {
        $this->buildClient();

        $this->assertEquals([], $this->sdk->getHeaders());

        $this->sdk->setHeaders($headers = [
            'foo' => 'bar'
        ]);

        $this->assertEquals($headers, $this->sdk->getHeaders());
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

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );
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
            200,
            $response->getStatusCode()
        );

        $response = json_decode($response->getBody()->getContents());

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

        $this->assertEquals(
            201,
            $response->getStatusCode()
        );

        $response = json_decode($response->getBody()->getContents());

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

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );

        $response = json_decode($response->getBody()->getContents());

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

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );

        $response = json_decode($response->getBody()->getContents());

        $this->assertNotNull($response);
    }
}
