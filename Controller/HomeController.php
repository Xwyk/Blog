<?php

namespace Blog\Controller;
// require __DIR__."/../View/View.php";
use Blog\Model\Manager\PostManager;
use Blog\Framework\Controller;

class HomeController extends Controller{
	
	public function home()
	{
		$articles = PostManager::getAllPosts();
		$this->render('home', ['articles' => $articles]);
	}
	
	public function display()
	{
		$this->home():
	}	
}
