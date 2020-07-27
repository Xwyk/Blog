<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\Framework\View;
use Blog\Framework\Session;

class LoginController extends Controller{
	
	public function display()
	{
		if(!isset($_POST['email']) || !isset($_POST['password'])){
			$this->render('login');	
			return;
		}
		$this->login();
		
	}

	private function login(){
		try{			
			$this->session->login(UserManager::login(
				filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL),
				filter_input(INPUT_POST, 'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			));
			$this->redirect('/');
		}catch(\Exception $e){
			$this->render('login', ['error' => $e->getMessage()]);
		}
	}


	public function logout()
	{
		$this->session->logout();
		$this->redirect('/');
	}
}
