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
use Blog\Exceptions\PostNotFoundException;
use Blog\Exceptions\ExpiredSessionException;
use Blog\Exceptions\UserNotConnectedException;
use Blog\Exceptions\ViewNotFoundException;
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'home';

    $config  = new Configuration(__DIR__.'/../config/config.local.ini');
    var_dump($config->getRoutes());
    $view    = new View($config);
try {
    $session = new Session($config);
    switch ($action) {
        case 'home':
            (new HomeController($view, $session, $config))->display();
            break;
        case 'login':
            (new LoginController($view, $session, $config))->display();
            break;
        case 'logout':
            (new LoginController($view, $session, $config))->logout();
            break;
        case 'register':
            (new RegisterController($view, $session, $config))->display();
            break;
        case 'post':
            (new PostController($view, $session, $config))->display();
            break;
        case 'addComment':
            (new CommentController($view, $session, $config))->add();
            break;
        case 'validateComment':
            (new CommentController($view, $session, $config))->validate();
            break;
        case 'invalidateComment':
            (new CommentController($view, $session, $config))->invalidate();
            break;
        case 'removeComment':
            (new CommentController($view, $session, $config))->remove();
            break;
        case 'admin':
            (new AdminController($view, $session, $config))->display();
            break;
        case 'addPost':
            (new PostController($view, $session, $config))->addPost();
            break;
        case 'editPost':
            (new PostController($view, $session, $config))->editPost();
            break;
        case 'removePost':
            (new PostController($view, $session, $config))->removePost();
            break;
        default:
            throw new Exception("La page demandée n'existe pas ou a été déplacée", $code=404);
            break;
    }
} catch (ExpiredSessionException $e) {
    header("Location: /?action=login");
} catch (UserNotConnectedException $e) {
    header("Location: /?action=login");
} catch (\Exception $e){
    (new ErrorController($view, $session, $config))->display($e);
}