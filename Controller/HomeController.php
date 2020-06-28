<?php

namespace Blog\Controller;
// require __DIR__."/../View/View.php";
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\UserManager;
use Blog\Model\User;
use Blog\Framework\Controller;
use Blog\Framework\View;

class HomeController extends Controller{
	
	public function home()
	{
		$articles = PostManager::getAllPosts();
		$this->render('home', ['articles' => $articles]);
	}

	public function display()
	{
		$articles = PostManager::getAllPosts();
		$this->render('home', ['articles' => $articles]);
	}
}