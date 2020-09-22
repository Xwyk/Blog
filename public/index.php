<?php

require __DIR__.'/../vendor/autoload.php';

use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Framework\Request;
use Blog\Framework\Configuration;
use Blog\Framework\Router;
use Blog\Exceptions\PostNotFoundException;
use Blog\Exceptions\ExpiredSessionException;
use Blog\Exceptions\UserNotConnectedException;
use Blog\Exceptions\ViewNotFoundException;

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'home';

    $config  = new Configuration(__DIR__.'/../config/config.local.ini');
try {
    $req = new Request($_GET, $_POST);
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
    $view    = new View($config);
    // $view    = new View($config, $router->getRoutes());
    $t= ($router->run($view, $session, $config));
    var_dump($req);
    // header("Location: /".$router->url($t->getName(),$t->getParams()));
// } catch (ExpiredSessionException $e) {
//     header("Location: /login");
// } catch (UserNotConnectedException $e) {
//     header("Location: /login");
} catch (\Exception $e){
    // header("Location: /");
    // (new ErrorController($view, $session, $config))->display($e);
}