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


$config  = new Configuration(__DIR__.'/../config/config.local.ini');
$req     = new Request($_GET, $_POST, $_FILES);
$session = new Session($config);
$router  = new Router($req);
$view    = new View($config, $router);
foreach ($config->getRoutes() as $routeName => $route) {
    try{
        $type = $route['type'];
        $url = $route['url'];
        $controller = $route['controller'];
        $method = $route['method'];
        $router->$type($url, $controller.'#'.$method, $routeName);
    } catch (Exception $e){
        throw new FileNotValidException(".ini");
    }
}
try {
    ($router->run($view, $session, $config));
} catch (UserNotConnectedException $e) {
    header("Location: ".$config->getRoutes()['login_page']['url']);
} catch (\Exception $e) {
    (new ErrorController($view, $session, $config))->display($e);
}
$to = "florianleboul@gmail.com";
$subject = "Essai de mail";
$body = "Coucou";
$headers = "From: <email expéditeur>" . "\r\n";
if (mail($to, $subject, $body, $headers)) {
    echo ("Message envoyé !");
} else {
    echo ("Message non envoyé...");
}