<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase;

use League\Container\Container;
use GuzzleHttp\Client as HttpClient;

class Client
{
    protected HttpClient $httpClient;

    protected Container $container;

    public function __construct()
    {
        $this->httpClient = new HttpClient();
        $this->container = new Container();
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function add(...$resources): void
    {
        foreach($resources as $resource) {
            $this->container->add($resource);
        }
    }

    public function build(array $resources): void
    {
        foreach($resources as $resource) {
            $this->add($resource);
        }
    }
}
