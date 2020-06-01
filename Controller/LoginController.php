<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\View\View;

class LoginController extends Controller{
	
	static public function login()
	{
		View::render('login');
		// require __DIR__.'/../View/home/home.php';
	}
	static public function display(){

	}
}