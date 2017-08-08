<?php

namespace AppBundle\Services\Transformers;

use Carbon\Carbon;

abstract class TransformerAbstract
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function create()
    {
        return array_map(function($item) {
            return $this->transform($item);
        }, $this->data);
    }

    public function getHumanReadableDifference($timestamp) {
        return Carbon::createFromTimestamp($timestamp)->diffForHumans();
    }

    abstract public function transform($item);

}