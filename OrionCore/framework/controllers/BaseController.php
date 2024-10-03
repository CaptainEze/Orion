<?php

namespace OrionCore\Framework\Controllers;

class BaseController
{
    protected $permisionClasses, $middlewares;
    public function __construct(array $middlewares = [], array $permisionClasses = [])
    {
        $this->middlewares = $middlewares;
        $this->permisionClasses = $permisionClasses;
    }

    protected function exec() : void
    {
        
    }
}