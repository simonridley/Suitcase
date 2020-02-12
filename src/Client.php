<?php

declare(strict_types=1);

namespace JustSteveKing\Suitcase;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    protected string $url;

    protected array $filters = [];

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

    public function update($identifier, array $data, string $method = "PUT")
    {
        return $this->call($method, $data, "/{$identifier}");
    }

    public function delete($identifier)
    {
        return $this->call('DELETE', [], "/{$identifier}");
    }

    protected function call(string $method, array $data = [], string $append = null, array $headers = []): ResponseInterface
    {
        if (! is_null($append)) {
            $this->url = $this->getUrl() . $append;
        }

        if (! is_null($this->buildFilters())) {
            $this->url = $this->getUrl() . '?' . $this->buildFilters();
        }

        $client = $this->getHttpClient();
        try {
            $response = $client->request(
                $method,
                $this->getUrl(),
                [
                    'data' => $data,
                    'headers' => array_merge($this->getOptions()['headers'] ?? [], $headers)
                ]
            );
        } catch(ClientException $e) {
            throw new ClientException;
        }

        return $response;
    }

    public function addFilters(array $filters): void
    {
        foreach($filters as $key => $filter) {
            $this->filters[$key] = $filter;
        }
    }

    public function buildFilters():? string
    {
        if (empty($this->getFilters())) {
            return null;
        }

        return http_build_query($this->getFilters());
    }

    public function getFilters(): array
    {
        return $this->filters;
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
