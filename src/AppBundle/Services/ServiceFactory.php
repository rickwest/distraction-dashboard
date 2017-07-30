<?php

namespace AppBundle\Services;

use AppBundle\Services\Transformers\HackernewsTransformer;
use AppBundle\Services\Transformers\RedditTransformer;
use GuzzleHttp\Client;

class ServiceFactory
{
    /** @var Client $client */
    protected $client;

    protected $enabledServices = [
        'reddit', 'hackernews'
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
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
        $data = (new HackerNews($this->client))->get();
        return (new HackernewsTransformer($data))->create();
    }

    protected function reddit()
    {
        $data = (new Reddit($this->client))->get();
        return (new RedditTransformer($data))->create();
    }
}