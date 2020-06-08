<?php

require __DIR__.'/vendor/autoload.php';

require __DIR__.'/config.local.php';

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
		if(isset($_POST['email']) && isset($_POST['password'])){
			LoginController::login();
		} else{

		LoginController::display();
		}

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

