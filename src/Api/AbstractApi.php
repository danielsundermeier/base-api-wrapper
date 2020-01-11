<?php

namespace Dasumi\BaseApiWrapper\Api;

use Dasumi\BaseApiWrapper\Client;

class AbstractApi
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}