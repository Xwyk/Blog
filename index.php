<?php

require __DIR__.'/vendor/autoload.php';

use Blog\Controller\HomeController;
use Blog\Controller\PostController;
use Blog\Controller\LoginController;
use Blog\Exceptions\PostNotFoundException;

$action = $_GET['action'] ?? 'home';


try{
switch ($action) {
	case 'home':
		HomeController::home();
		break;
	case 'login':
		LoginController::login();
		break;
	case 'post':
		if (!isset($_GET['id'])) {
			// 404
		}
		PostController::displayPostById($_GET['id']);
		break;
	default:
		// Gerer une 404
		break;
}

}
catch(PostNotFoundException $e){
	echo $e->id;
}

