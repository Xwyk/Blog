<?php

namespace Blog\Controller;
// require __DIR__."/../View/View.php";
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\UserManager;
use Blog\Model\User;
use Blog\Framework\Controller;
use Blog\View\View;

class HomeController extends Controller{
	
	static public function home()
	{
		$articles = PostManager::getAllPosts();
		View::render('home', ['articles' => $articles]);
		// require __DIR__.'/../View/home/home.php';
	}
	static public function display(){

	}
}