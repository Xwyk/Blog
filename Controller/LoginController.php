<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\View\View;

class LoginController extends Controller{
	
	static public function login()
	{
		if(!isset($_POST['email']) || !isset($_POST['password'])){
			throw new Exception("Identifiant ou mot de passe non saisi", 1);
		}
		UserManager::login($_POST['email'],$_POST['password']);

	}
	static public function logout()
	{
		if(!isset($_SESSION['user'])){
			throw new Exception("Aucune session en cours", 1);
		}
		UserManager::logout();

	}
	static public function display(){
		View::render('login');
	}
}