<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Framework\View;

class PostController extends Controller{
	
	public function displayPostById(int $id)
	{		
		$post = PostManager::getPostById($id);
		$this->render('post',['post' => $post]);
	}
}