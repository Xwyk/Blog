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
    // var_dump($config->getRoutes());
    $view    = new View($config);
try {
    $session = new Session($config);
    $router = new Router($_GET['url']);
    $router->get('/', 'Home#display');
    $router->get('/admin', 'Admin#display');
    $router->post('/comments/:id/validate', 'Comment#validate');
    $router->post('/comments/:id/invalidate', 'Comment#invalidate');
    $router->post('/comments/:id/remove', 'Comment#remove');
    $router->get('/home', 'Home#display');
    $router->get('/login', 'Login#display');
    $router->post('/login', 'Login#login');
    $router->get('/logout', 'Login#logout');
    $router->get('/posts/add', 'Post#add');
    $router->post('/posts/add', 'Post#add');
    $router->get('/posts/:id', 'Post#display');
    $router->post('/posts/:id/edit', 'Post#edit');
    $router->post('/posts/:id/remove', 'Post#remove');
    $router->post('/posts/:id/addComment', 'Comment#add');
    $router->get('/register', 'Register#display');
    $router->post('/register', 'Register#display');
    foreach ($config->getRoutes() as $routeName => $route) {
        var_dump($route);
        var_dump($routeName);
    }

    $router->run();
// } catch (ExpiredSessionException $e) {
//     header("Location: /login");
// } catch (UserNotConnectedException $e) {
//     header("Location: /login");
} catch (\Exception $e){
    (new ErrorController($view, $session, $config))->display($e);
}