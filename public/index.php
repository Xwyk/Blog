<?php

require __DIR__.'/../vendor/autoload.php';

use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Framework\Request;
use Blog\Framework\Configuration;
use Blog\Framework\Router;
use Blog\Exceptions\ExpiredSessionException;


$config  = new Configuration(__DIR__.'/../config/config.local.ini');
$req = new Request($_GET, $_POST);
$session = new Session($config);
$router = new Router($_GET['url']);
$view    = new View($config, $router);
foreach ($config->getRoutes() as $routeName => $route) {
    try{
        $type = $route['type'];
        $url = $route['url'];
        $controller = $route['controller'];
        $method = $route['method'];
    } catch (Exception $e){
        throw new FileNotValidException(".ini");
    }
    $router->$type($url, $controller.'#'.$method, $routeName);
}
// $view    = new View($config, $router->getRoutes());
$t= ($router->run($view, $session, $config));
var_dump($req->getDecodedRedirection());
