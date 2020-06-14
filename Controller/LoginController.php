<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\Framework\View;
use Blog\Framework\Session;

class LoginController extends Controller{
	
	static public function login()
	{
		try{			
			if(!isset($_POST['email']) || !isset($_POST['password'])){
				throw new \Exception("Identifiant ou mot de passe non saisi", 1);
			}
			Session::addAttribute('username', UserManager::login($_POST['email'],$_POST['password'])->getPseudo());
			self::redirect('/');
		}catch(\Exception $e){
			View::render('login', ['errors' => $e->getMessage()]);
		}
		View::render('login');

	}
	static public function logout()
	{
		if (Session::exists()) {
			Session::stop();
		}
		self::redirect('/');
	}

	static public function display()
	{
		# code...
	}
}