<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

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

    public function list(string $url = null)
    {
        return $this->call('GET', [], $url);
    }

    public function get($identifier)
    {
        return $this->call('GET', [], "/{$identifier}");
    }

    public function create(array $data)
    {
        return $this->call('POST', $data);
    }

    public function update($identifier, array $data)
    {
        return $this->call('PUT', $data, "/{$identifier}");
    }

    public function delete($identifier)
    {
        return $this->call('DELETE', [], "/{$identifier}");
    }

    protected function call(string $method, array $data = [], string $append = null, array $headers = [])
    {
        if (! is_null($append)) {
            $this->url = $this->getUrl() . $append;
        }

        $client = $this->getHttpClient();
        try {
            $response = $client->request(
                $method,
                $this->getUrl(),
                $data
            );
        } catch(ClientException $e) {
            throw new Exception($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    public function getResources(): array
    {
        return $this->resources;
    }

    public function getOptions(): array
    {
        return $this->options;
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
