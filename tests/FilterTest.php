<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase\Tests;

use PHPUnit\Framework\TestCase;
use JustSteveKing\Suitcase\Client;

class FilterTest extends TestCase
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

    public function testFiltersCanBeBuilt()
    {
        $this->buildClient();

        $this->sdk->addFilters([
            'userId' => 1
        ]);

        $this->assertArrayHasKey('userId', $this->sdk->getFilters());
    }

    public function testFilterStringCanBeCreated()
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

    public function testCanCustomiseHowFiltersAreBuilt()
    {
        $this->buildClient();

        $this->sdk->addFilters([
            'filter[userId]' => 1
        ]);

        $this->assertEquals(
            "filter[userId]=1",
            $this->sdk->buildFilters()
        );
    }

    public function testCanRunAGetRequestForResourcesWithFilters()
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

        $this->assertEquals(
            200,
            $response->getStatusCode()
        );

        $response = json_decode($response->getBody()->getContents());

        $this->assertTrue(is_array($response));
    }
}
