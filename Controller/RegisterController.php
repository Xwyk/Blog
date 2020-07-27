<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\User;
use Blog\Model\Manager\UserManager;

class RegisterController extends Controller{
	
	public function register()
	{
		try{
			$userToAdd = new User([
				'firstName' => filter_input(INPUT_POST, 'firstName',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'lastName' => filter_input(INPUT_POST, 'lastName',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'pseudo' => filter_input(INPUT_POST, 'pseudo',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'mailAddress' => filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL),
				'password' => filter_input(INPUT_POST, 'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			]);
			UserManager::add($userToAdd);
			$this->redirect('/?action=login');

		}
		catch (\Exception $e){
			$this->render('register', ['error'=>$e->getMessage()]);
		}
	}

	public function display()
	{
		if (empty($_POST)) {
			$this->render('register');
			return;
		}
		$this->register();
	}
}
