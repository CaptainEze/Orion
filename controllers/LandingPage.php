<?php
namespace Controllers;
use OrionCore\Framework\Controllers\ViewController;

class LandingPage extends ViewController
{
    public function __construct(array $middlewares = [], array $permisionClasses = [])
    {
        $this->view = 'home';
        $this->context = [
            'title' => 'Home Page',
            'user' => 'John Doe'
        ];

        parent::__construct($middlewares, $permisionClasses);
    }

    protected function activity():void {
        
    }
    
}
