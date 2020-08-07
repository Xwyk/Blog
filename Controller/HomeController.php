<?php

namespace Blog\Controller;
// require __DIR__."/../View/View.php";
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\TokenManager;
use Blog\Framework\Controller;

class HomeController extends Controller{
	
	public function display()
	{
		$articles = (new PostManager($this->config))->getAllPosts();
		$this->render($this::VIEW_HOME, ['articles' => $articles]);
	}
}
