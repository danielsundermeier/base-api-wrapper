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
}