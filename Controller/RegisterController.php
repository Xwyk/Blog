<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\Framework\View;

class RegisterController extends Controller{
	
	public function register()
	{
		$firstName = filter_input(INPUT_POST, 'firstName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lastName = filter_input(INPUT_POST, 'lastName',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$pseudo = filter_input(INPUT_POST, 'pseudo',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$mail = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST, 'password',FILTER_VALIDATE_INT);

		var_dump($_POST);
	}

	public function display()
	{
		$this->render('register');
		$this->register();
	}
}