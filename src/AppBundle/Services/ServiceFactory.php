<?php

namespace AppBundle\Services;

use AppBundle\Services\Transformers\HackernewsTransformer;
use AppBundle\Services\Transformers\RedditTransformer;
use GuzzleHttp\Client;
use Psr\SimpleCache\CacheInterface;

class ServiceFactory
{
    const SERVICE_HACKER_NEWS = 'hackernews';
    const SERVICE_REDDIT = 'reddit';

    /** @var Client $client */
    protected $client;
    /** @var  CacheInterface $cache */
    protected $cache;

    protected $enabledServices = [
        'reddit', 'hackernews'
    ];

    public function __construct(CacheInterface $cache) {
        $this->client = new Client();
        $this->cache = $cache;
    }

    public function get($service, $limit = 10)
    {
        if (method_exists($this, $service) && $this->isServiceEnabled($service)) {
            // Not currently sorting by timestamp as we are now formatting date prior
            return $this->{$service}($limit);
        }

        return 'service not enabled';
    }

    protected function isServiceEnabled($service)
    {
        return in_array($service, $this->enabledServices);
    }

    protected function sortResponseByTimestamp($data)
    {
        usort($data, function($a, $b){
            return $a['timestamp'] - $b['timestamp'];
        });
        return $data;
    }

    protected function hackernews()
    {
        if (!$this->cache->has(self::SERVICE_HACKER_NEWS)) {
            $hackernews = new HackerNews($this->client);
            $this->cache->set(self::SERVICE_HACKER_NEWS, ($hackernews->get()));
        }

        $hackernewsTransformer =  new HackernewsTransformer($this->cache->get(self::SERVICE_HACKER_NEWS));
        return $hackernewsTransformer->create();
    }

    protected function reddit()
    {
        if (!$this->cache->has(self::SERVICE_REDDIT)) {
            $reddit = new Reddit($this->client);
            $this->cache->set(self::SERVICE_REDDIT, $reddit->get());
        }

        $redditTransformer = new RedditTransformer($this->cache->get(self::SERVICE_REDDIT));
        return $redditTransformer->create();
    }
}