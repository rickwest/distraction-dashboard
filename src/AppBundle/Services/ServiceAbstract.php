<?php

namespace AppBundle\Services;

use GuzzleHttp\Client;

abstract class ServiceAbstract
{
    /** @var Client $client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    abstract public function get($limit = 10);
}