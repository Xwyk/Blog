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
				throw new \Exception("");
			}
			$this->session->login(UserManager::login($_POST['email'],$_POST['password']));
			$this->redirect('/');
		}catch(\Exception $e){
			$this->render('login', ['errors' => $e->getMessage()]);
		}
	}

	public function display()
	{
		try{			
			if(!isset($_POST['email']) || !isset($_POST['password'])){
				throw new \Exception("");
			}
			$this->session->login(UserManager::login($_POST['email'],$_POST['password']));
			$this->redirect('/');
		}catch(\Exception $e){
			$this->render('login', ['errors' => $e->getMessage()]);
		}
	}


	public function logout()
	{
		$this->session->logout();
		$this->redirect('/');
	}
	
	public function display()
	{
	}
}
