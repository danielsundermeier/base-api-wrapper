<?php

namespace Dasumi\BaseApiWrapper\Tests;

use Dasumi\BaseApiWrapper\Api;


class ApiTest extends \Dasumi\BaseApiWrapper\Tests\TestCase
{
    /**
     * @test
     */
    public function it_can_be_instantiated()
    {
        $api = new Api();
        $this->assertEquals(Api::class, get_class($api));
    }
}

