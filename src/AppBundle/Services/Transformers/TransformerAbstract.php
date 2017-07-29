<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 29/07/2017
 * Time: 23:03
 */

namespace AppBundle\Services\Transformers;


abstract class TransformerAbstract
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function create()
    {
        return array_map(function($item){
            return $this->transform($item);
        }, $this->data);
    }

    abstract public function transform($item);
}