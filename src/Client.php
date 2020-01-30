<?php

namespace Dasumi\BaseApiWrapper;

class Client
{
    protected $client;

    public function __construct(array $config = [])
    {
        $this->setUp();
        $this->setClient($config);
    }

    protected function setUp() : void
    {
        //
    }

    protected function setClient(array $config = []) : void
    {
        $this->client = new \GuzzleHttp\Client($config);
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
        // TODO: merge $options witch default delete options

        $response = $this->client->send($request, $options);

        return json_decode($response->getBody(), true);
    }
}