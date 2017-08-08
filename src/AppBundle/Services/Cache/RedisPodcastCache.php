<?php

namespace AppBundle\Services\Cache;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Simple\RedisCache;

class RedisPodcastCache
{
    protected $cache;

    public function __construct()
    {
        $this->cache = new RedisCache(
            RedisAdapter::createConnection('redis://127.0.0.1:6379'),
            '',
            600
        );
    }

    public function getCache()
    {
        return $this->cache;
    }
}