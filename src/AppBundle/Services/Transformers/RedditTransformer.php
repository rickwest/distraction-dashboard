<?php

namespace AppBundle\Services\Transformers;

class RedditTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'title' => $data['data']['title'],
            'link' => 'https://reddit.com' . $data['data']['permalink'],
            'timestamp' => $data['data']['created'],
            'service' => 'Reddit',
        ];
    }
}