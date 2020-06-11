<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\Framework\View;

class LoginController extends Controller{
	
	static public function login()
	{
		try{			
			if(!isset($_POST['email']) || !isset($_POST['password'])){
				throw new \Exception("Identifiant ou mot de passe non saisi", 1);
			}
			$_SESSION['user'] = UserManager::login($_POST['email'],$_POST['password']);
			self::redirect('/');
		}catch(\Exception $e){
			View::render('login', ['errors' => $e->getMessage()]);
		}
		View::render('login');

	}
	static public function logout()
	{
		if(!isset($_SESSION['user'])){
			throw new Exception("Aucune session en cours", 1);
		}
		UserManager::logout();
		self::redirect('/');


	}

	static public function display()
	{
		# code...
	}
}