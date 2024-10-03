<?php
require "./vendor/autoload.php";

use OrionCore\Framework\Router\Router;
use Controllers\LandingPage;


$router = new Router(); 

$router->new("GET","/", new LandingPage());


$router->matchRoute();