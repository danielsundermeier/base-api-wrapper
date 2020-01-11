<?php

namespace Dasumi\BaseApiWrapper;

use Dasumi\BaseApiWrapper\Client;

class Api
{
    protected $client;

    public function __construct()
    {
        $this->setUp();
    }

    protected function setUp() : void
    {
        $this->registerEndpoints();
    }

    protected function getClient() : Client
    {
        return new Client();
    }

    protected function registerEndpoints()
    {
        $client = $this->getClient();

        $this->setEndpoints($client);

        return $this;
    }

    protected function setEndpoints(Client $client) : void
    {

    }
}