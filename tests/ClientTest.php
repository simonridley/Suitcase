<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase\Tests;

use League\Container\Container;
use PHPUnit\Framework\TestCase;
use JustSteveKing\Suitcase\Client;
use GuzzleHttp\Client as HttpClient;

class ClientTest extends TestCase
{
    protected Client $sdk;

    protected function setUp(): void
    {
        $this->sdk = new Client();
    }

    public function testClientCanBeCreated()
    {
        $this->assertInstanceOf(Client::class, $this->sdk);
    }

    public function testClientHasContainerAvailable()
    {
        $this->assertInstanceOf(Container::class, $this->sdk->getContainer());
    }

    public function testResourcesCanBeAddedToContainer()
    {
        $this->sdk->add(
            Item::class,
            Resource::class
        );

        $container = $this->sdk->getContainer();

        $this->assertEquals(
            Item::class,
            $container->get(Item::class)
        );

        $this->assertEquals(
            Resource::class,
            $container->get(Resource::class)
        );
    }

    public function testResourceCanBeAddedThroughBuildFunction()
    {
        $this->sdk->build([
            Item::class,
            Resource::class
        ]);

        $container = $this->sdk->getContainer();

        $this->assertEquals(
            Item::class,
            $container->get(Item::class)
        );

        $this->assertEquals(
            Resource::class,
            $container->get(Resource::class)
        );
    }

    public function testHttpClientCanBeAccessed()
    {
        $this->assertInstanceOf(HttpClient::class, $this->sdk->getHttpClient());
    }
}
