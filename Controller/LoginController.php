<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\Framework\View;
use Blog\Framework\Session;

class LoginController extends Controller{
	
	public function login()
	{
		try{			
			if(!isset($_POST['email']) || !isset($_POST['password'])){
				throw new \Exception("Identifiant ou mot de passe non saisi", 1);
			}
			$this->session->addAttribute('username', UserManager::login($_POST['email'],$_POST['password'])->getPseudo());
			$this->redirect('/');
		}catch(\Exception $e){
			$this->render('login', ['errors' => $e->getMessage()]);
		}

	}
	public function logout()
	{
		if (Session::exists()) {
			Session::stop();
		}
		$this->redirect('/');
	}
	
	public function display()
	{
	}
}
