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
	$controller = null;
	$view = new View();
	$session = new Session();
switch ($action) {
	case 'home':
			(new HomeController($view, $session))->home();
			break;
	case 'login':
			(new LoginController($view, $session))->login();
		break;
	case 'logout':
			(new LoginController($view, $session))->logout();
		break;
	case 'register':
			(new RegisterController($view, $session))->display();
		break;
	case 'post':
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id === false) {
			throw new PostNotFoundException($id);
		}
		(new PostController($view, $session))->displayPostById($id);
		break;
	default:
		// Gerer une 404
		break;
}

}
catch(PostNotFoundException $e){
	echo $e->message;
}

