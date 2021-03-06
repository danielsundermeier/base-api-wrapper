<?php

namespace Dasumi\BaseApiWrapper\Tests;

use Dasumi\BaseApiWrapper\Client;

class ClientTest extends \Dasumi\BaseApiWrapper\Tests\TestCase
{
    protected $client;

    protected function setUp() : void
    {
        $this->client = new Client([
            'base_uri' => 'http://httpbin.org',
            'timeout'  => 2.0,
        ]);
    }

    /**
     * @test
     */
    public function it_can_get_with_query()
    {
        $data = $this->client->get('get', ['a' => 1]);
        $this->assertEquals(['a' => 1], $data['args']);
    }

    /**
     * @test
     */
    public function it_can_get_with_options()
    {
        $data = $this->client->get('get', [], [
            'query' => [
                'a' => 1,
            ],
            'debug' => false,
        ]);
        $this->assertEquals(['a' => 1], $data['args']);
    }

    /**
     * @test
     */
    public function it_can_get_with_query_and_options()
    {
        $data = $this->client->get('get', ['a' => 1], [
            'query' => [
                'b' => 2,
            ],
        ]);
        $this->assertEquals(['a' => 1, 'b' => 2,], $data['args']);
    }

    /**
     * @test
     */
    public function it_can_get_with_query_and_options_merged()
    {
        $data = $this->client->get('get', ['b' => 2], [
            'query' => [
                'b' => 1,
            ],
        ]);
        $this->assertEquals(['b' => 1,], $data['args']);
    }

    /**
     * @test
     */
    public function it_can_delete_with_body()
    {
        $data = $this->client->delete('delete', 'a');
        $this->assertEquals('a', $data['data']);
    }

    /**
     * @test
     */
    public function it_can_make_a_snapshot_of_the_body()
    {
        $path = 'snapshots/get.json';

        $this->assertFileNotExists($path);

        $data = $this->client->snapshot()->get('get', ['b' => 2], [
            'query' => [
                'b' => 1,
            ],
        ]);

        $this->assertFileExists($path);

        unlink($path);
    }

    /**
     * @test
     */
    public function it_can_set_attributes()
    {
        $this->assertNull($this->client->foo);

        $this->client->foo = 'bar';

        $attributes = $this->client->getAttributes();

        $this->assertEquals('bar', $attributes['foo']);
        $this->assertEquals('bar', $this->client->foo);
    }

    /**
     * @test
     */
    public function it_can_add_attributes_to_request_options()
    {
        $client = new ClientWithApiToken([
            'base_uri' => 'http://httpbin.org',
            'timeout'  => 2.0,
        ]);
        $api_key = '123456';

        $data = $client->get('get');
        $this->assertEquals([], $data['args']);

        $client->api_key = $api_key;

        $data = $client->get('get');
        $this->assertEquals(['api_key' => $api_key], $data['args']);
    }
}

class ClientWithApiToken extends Client
{
    protected function getRequestOptions(array $options) : array
    {
        if (is_null($this->api_key)) {
            return $options;
        }

        $options['query']['api_key'] = $this->api_key;

        return $options;
    }
}