<?php

namespace OrionCore\Framework\Controllers;

use OrionCore\Framework\Render\Render;

class ViewController extends BaseController
{
    private $View;
    public function __construct(array $middlewares, array $permisionClasses = [])
    {
        $this->View = new Render($_SERVER['DOCUMENT_ROOT'] . "/views", $_SERVER['DOCUMENT_ROOT'] . "/cache");
        parent::__construct($middlewares, $permisionClasses);
    }



    protected function activity () {}

    public function render()
    {
        parent::exec();
        $this -> activity();
        $this->View->render($this->view, $this->context);
    }
}