<?php

namespace AppBundle\Services\Transformers;

class HackernewsTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'title' => $data['title'],
            'link' => isset($data['url']) ? $data['url'] : 'https://news.ycombinator.com/item?id=' . $data['id'],
            'timestamp' => $this->getHumanReadableDifference($data['time']),
            'service' => 'Hacker News',
        ];
    }
}