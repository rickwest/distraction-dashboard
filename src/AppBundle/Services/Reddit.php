<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 29/07/2017
 * Time: 23:31
 */

namespace AppBundle\Services;


use GuzzleHttp\Exception\TransferException;

class Reddit extends ServiceAbstract
{
    public function get($limit = 10)
    {
        try {
            $response = $this->client->get(
                'https://www.reddit.com/r/programming.json?limit=' . $limit, [
                    'headers' => ['User-Agent' => 'Distract']
                ]
            );
        } catch (TransferException $e) {
            $response = null;
        }

        $data = [];
        if ($response) {
            $data = json_decode($response->getBody()->getContents(), true);
        }

        return $data['data']['children'];



    }
}