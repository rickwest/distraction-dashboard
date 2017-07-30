<?php

namespace AppBundle\Services;

use AppBundle\Services\Transformers\HackernewsTransformer;
use AppBundle\Services\Transformers\RedditTransformer;
use GuzzleHttp\Client;
use Psr\SimpleCache\CacheInterface;

class ServiceFactory
{
    /** @var Client $client */
    protected $client;
    /** @var  CacheInterface $cache */
    protected $cache;

    protected $enabledServices = [
        'reddit', 'hackernews'
    ];

    public function __construct(
        Client $client,
        CacheInterface $cache
    ) {
        $this->client = $client;
        $this->cache = $cache;
    }
    
    public function get($service, $limit = 10)
    {
        if (method_exists($this, $service) && $this->isServiceEnabled($service)) {
            return $this->sortResponseByTimestamp($this->{$service}($limit));
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
        if (!$this->cache->has('hackernews')) {
            $this->cache->set('hackernews', (new HackerNews($this->client))->get());
        }
        return (new HackernewsTransformer($this->cache->get('hackernews')))->create();
    }

    protected function reddit()
    {
        if (!$this->cache->has('reddit')) {
            $this->cache->set('reddit', (new Reddit($this->client))->get());
        }
        return (new RedditTransformer($this->cache->get('reddit')))->create();
    }
}