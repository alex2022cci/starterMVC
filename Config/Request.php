<?php

class Request
{
    /**
     * Invocation d'url 
     * @var mixed $url
     */
    public $url;
    public function __construct()
    {
        $this->url = $_SERVER['PATH_INFO'];
    }
}