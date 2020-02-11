<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase;

use Exception;
use GuzzleHttp\Client as HttpClient;

class Client
{
    protected string $url;

    protected array $options = [];

    protected array $resources = [];

    protected HttpClient $httpClient;

    public function __construct(array $options)
    {
        $this->options = array_merge($options, $this->options);

        $this->httpClient = new HttpClient([
            'base_uri' => $this->options['base_uri']
        ]);
    }

    public function __get(string $resource): self
    {
        if (! array_key_exists($resource, $this->resources)) {
            throw new Exception("No resource registered for: {$resource}");
        }

        $this->url = $resource;

        return $this;
    }

    public function add(array $resources)
    {
        foreach($resources as $key => $resource) {
            $this->resources[$key] = $resource;
        }
    }

    public function get(string $url = null)
    {
        return $this->call('GET', [], $url);
    }

    protected function call(string $method, array $data = [], string $append = null, array $headers = [])
    {
        $http = $this->getHttpClient()->addHeaders(array_merge(
            $this->options['headers'] ?? [],
            $headers
        ));

        if (! is_null($append)) {
            $this->url = $this->getUrl() . $append;
        }

        dump($this->getUrl());
        die();

        $response = $http->setMethod($method)
            ->setURL($this->getUrl())
            ->setBody($data);
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
