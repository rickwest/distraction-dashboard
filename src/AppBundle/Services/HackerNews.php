<?php

namespace AppBundle\Services;

use GuzzleHttp\Exception\TransferException;

class HackerNews extends ServiceAbstract
{
    public function get($limit = 10)
    {
        try {
            $response = $this->client->get(
                'https://hacker-news.firebaseio.com/v0/topstories.json');
        } catch (TransferException $e) {
            $response = null;
        }

        $storyIds = [];
        if ($response) {
            $storyIds = array_slice(json_decode($response->getBody()), 0, $limit);
        }

        $stories = [];
        foreach ($storyIds as $storyId) {
            $response = $this->client->get(
                'https://hacker-news.firebaseio.com/v0/item/'.$storyId.'.json'
            );
            $stories[] = json_decode($response->getBody(), true);
        }
        return $stories;
    }
}