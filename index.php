<?php

require __DIR__.'/vendor/autoload.php';

use Blog\Controller\HomeController;
use Blog\Controller\PostController;
use Blog\Controller\CommentController;
use Blog\Controller\LoginController;
use Blog\Controller\RegisterController;
use Blog\Controller\AdminController;
use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Framework\Configuration;
use Blog\Model\User;
use Blog\Exceptions\PostNotFoundException;

$action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'home';


try{
	$view    = new View();
	$session = new Session();
	$config  = new Configuration(__DIR__.'/config/config.local.php');
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
			(new CommentController($view, $session, $config))->addComment();
			break;
		case 'validateComment':
			(new CommentController($view, $session, $config))->validateComment();
			break;
		case 'invalidateComment':
			(new CommentController($view, $session, $config))->invalidateComment();
			break;
		case 'admin':
			(new AdminController($view, $session, $config))->display();
			break;
		case 'addPost':
			(new PostController($view, $session, $config))->AddPost();
			break;
		default:
			var_dump(User::TYPE_ADMIN);
			break;
	}
}
catch(PostNotFoundException $e){
	echo $e->message;
}

