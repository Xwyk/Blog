<?php

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/config.local.php';

use Blog\Controller\HomeController;
use Blog\Controller\PostController;
use Blog\Controller\LoginController;
use Blog\Controller\RegisterController;
use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Exceptions\PostNotFoundException;

$action = filter_input(INPUT_GET, 'action',FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'home';


try{
	$view = new View();
	$session = new Session();
	switch ($action) {
		case 'home':
				(new HomeController($view, $session))->display();
				break;
		case 'login':
				(new LoginController($view, $session))->display();
			break;
		case 'logout':
				(new LoginController($view, $session))->logout();
			break;
		case 'register':
				(new RegisterController($view, $session))->display();
			break;
		case 'post':
			(new PostController($view, $session))->display();
			break;
		default:
			// Gerer une 404
			break;
	}
}
catch(PostNotFoundException $e){
	echo $e->message;
}

