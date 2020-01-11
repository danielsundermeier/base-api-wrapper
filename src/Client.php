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

    public function delete(string $path, string $body = '', array $options = []) : array
    {
        $options['body'] = $options['body'] ?? $body;

        $request = new \GuzzleHttp\Psr7\Request('DELETE', $path);

        return $this->send($request, $options);
    }

    public function get(string $path, array $query = [], array $options = []) : array
    {
        $options['query'] = (array_key_exists('query', $options) ? array_merge($query, $options['query']) : $query);

        $request = new \GuzzleHttp\Psr7\Request('GET', $path);

        return $this->send($request, $options);
    }

    public function postFormParams(string $path, array $data, array $options = []) : array
    {
        $options['form_params'] = $data;

        return $this->post($path, '', $options);
    }

    public function postJson(string $path, array $data, array $options = []) : array
    {
        $options['json'] = $data;

        return $this->post($path, '', $options);
    }

    public function post(string $path, string $body = '', array $options = []) : array
    {
        $options['body'] = $options['body'] ?? $body;

        $request = new \GuzzleHttp\Psr7\Request('POST', $path);

        return $this->send($request, $options);
    }

    public function put(string $path, string $body = '', array $options = []) : array
    {
        $options['body'] = $options['body'] ?? $body;

        $request = new \GuzzleHttp\Psr7\Request('PUT', $path);

        return $this->send($request, $options);
    }

    protected function send(\GuzzleHttp\Psr7\Request $request, array $options) : array
    {
        // TODO: merge $options witch default delete options

        $response = $this->client->send($request, $options);

        return json_decode($response->getBody(), true);
    }
}