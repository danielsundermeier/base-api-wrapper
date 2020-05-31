<?php

namespace Dasumi\BaseApiWrapper;

class Client
{
    protected $attributes = [];

    protected $client;

    protected $snapshot = false;

    public function __construct(array $config = [], array $attributes = [])
    {
        $this->setUp();
        $this->setClient($config);
    }

    protected function setClient(array $config = []) : void
    {
        $this->client = new \GuzzleHttp\Client($config);
    }


    protected function setUp() : void
    {
        //
    }


    public function delete(string $path, string $body = '', array $options = [])
    {
        $options['body'] = $options['body'] ?? $body;

        $request = $this->createRequest('DELETE', $path);

        return $this->send($request, $options);
    }

    public function get(string $path, array $query = [], array $options = [])
    {
        $options['query'] = (array_key_exists('query', $options) ? array_merge($query, $options['query']) : $query);

        $request = $this->createRequest('GET', $path);

        return $this->send($request, $options);
    }

    public function postFormParams(string $path, array $data, array $options = [])
    {
        $options['form_params'] = $data;

        return $this->post($path, '', $options);
    }

    public function postJson(string $path, array $data, array $options = [])
    {
        $options['json'] = $data;

        return $this->post($path, '', $options);
    }

    public function post(string $path, string $body = '', array $options = [])
    {
        $options['body'] = $options['body'] ?? $body;

        $request = $this->createRequest('POST', $path);

        return $this->send($request, $options);
    }

    public function put(string $path, string $body = '', array $options = [])
    {
        $options['body'] = $options['body'] ?? $body;

        $request = $this->createRequest('PUT', $path);

        return $this->send($request, $options);
    }

    protected function createRequest($method, $path) : \GuzzleHttp\Psr7\Request
    {
        return new \GuzzleHttp\Psr7\Request($method, $this->pathPrefix() . $path);
    }

    protected function pathPrefix() : string
    {
        return '';
    }

    protected function send(\GuzzleHttp\Psr7\Request $request, array $options)
    {
        $response = $this->client->send($request, $this->getRequestOptions($options));

        $body = $response->getBody();

        if ($this->snapshot) {
            Snapshot::handle($request, $response);
            $this->snapshot = false;
        }

        return json_decode($body, true);
    }

    protected function getRequestOptions(array $options) : array
    {
        return $options;
    }

    public function snapshot(bool $value = true) : self
    {
        $this->snapshot = $value;

        return $this;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function getAttributes() : array
    {
        return $this->attributes;
    }

    public function getAttribute($key)
    {
        if (! array_key_exists($key, $this->attributes)) {
            return null;
        }

        return $this->attributes[$key];
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}