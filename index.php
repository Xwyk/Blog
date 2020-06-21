<?php

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/config.local.php';

use Blog\Controller\HomeController;
use Blog\Controller\PostController;
use Blog\Controller\LoginController;
use Blog\Controller\RegisterController;
use Blog\Exceptions\PostNotFoundException;

$action = $_GET['action'] ?? 'home';

try{
switch ($action) {
	case 'home':
		(new HomeController())->home();
		break;
	case 'login':
			(new LoginController())->login();
		break;
	case 'logout':
			LoginController::logout();
		break;
	case 'register':
			(new RegisterController)->display();
		break;
	case 'post':
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id === false) {
			throw new PostNotFoundException($id);
		}
		(new PostController)->displayPostById($id);
		break;
	default:
		// Gerer une 404
		break;
}

}
catch(PostNotFoundException $e){
	echo $e->message;
}

