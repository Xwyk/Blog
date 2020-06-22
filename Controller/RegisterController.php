<?php

namespace Blog\Controller;
use Blog\Framework\Controller;

class RegisterController extends Controller{
	
	public function display()
	{
		$this->render('register');
	}
}
