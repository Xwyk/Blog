<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\UserManager;
use Blog\Framework\View;

class RegisterController extends Controller{
	
	public function display()
	{
		$this->render('register');
	}
}