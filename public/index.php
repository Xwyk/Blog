<?php

require __DIR__.'/../vendor/autoload.php';

use Blog\Controller\HomeController;
use Blog\Controller\PostController;
use Blog\Controller\CommentController;
use Blog\Controller\LoginController;
use Blog\Controller\RegisterController;
use Blog\Controller\AdminController;
use Blog\Controller\ErrorController;
use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Framework\Configuration;
use Blog\Framework\Router;
use Blog\Exceptions\PostNotFoundException;
use Blog\Exceptions\ExpiredSessionException;
use Blog\Exceptions\UserNotConnectedException;
use Blog\Exceptions\ViewNotFoundException;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'home';

    $config  = new Configuration(__DIR__.'/../config/config.local.ini');
    $view    = new View($config);
try {
    $session = new Session($config);
    $router = new Router($_GET['url']);
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
    $router->run($view, $session, $config);
// } catch (ExpiredSessionException $e) {
//     header("Location: /login");
// } catch (UserNotConnectedException $e) {
//     header("Location: /login");
} catch (\Exception $e){
    (new ErrorController($view, $session, $config))->display($e);
}