<?php

Class Dispatcher
{
    /**
     * Summary of request
     * @var \Request $request
     */
    var $request;

    public function __construct()
    {
        $this->request = new Request();
    }
}