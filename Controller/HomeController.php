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
<<<<<<< HEAD

	public function display()
	{
		$articles = PostManager::getAllPosts();
		$this->render('home', ['articles' => $articles]);
	}
}
=======
	
	public function display()
	{
		$this->home():
	}	
}
>>>>>>> 92e4a88bd9d4558d542c1b51abccdd6ef96827ff
