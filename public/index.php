<?php

require __DIR__.'/../vendor/autoload.php';

use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Framework\Request;
use Blog\Framework\Configuration;
use Blog\Framework\Router;
use Blog\Exceptions\ExpiredSessionException;
use Blog\Exceptions\UserNotConnectedException;
use Blog\Controller\ErrorController;


// try {
    $config  = new Configuration(__DIR__.'/../config/');
    $req     = new Request($_GET, $config, $_POST, $_FILES);
    $router  = new Router($req);
    $session = new Session($config);
    $view    = new View($config, $router);
    foreach ($config->getRoutes() as $routeName => $route) {
        try{
            $type = $route['type'];
            $url = $route['url'];
            $controller = $route['controller'];
            $method = $route['method'];
            $router->$type($config->getWebsiteRoot().$url, $controller.'#'.$method, $routeName);
        } catch (Exception $e){
            throw new FileNotValidException(".ini");
        }
    }
    ($router->run($view, $session, $config));
// } catch (UserNotConnectedException $e) {
//     http_response_code(401);
//     header("Location: /".$router->url('login_page'));
// } catch (\Exception $e) {
//     http_response_code(401);
//     header("Location: /".$router->url('home_page'));
// }