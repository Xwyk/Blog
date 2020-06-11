<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Framework\View;

class PostController extends Controller{
	
	static public function displayPostById(int $id)
	{
		if ($id<0) {
			throw new OutOfRangeException("L'ID d'un article ne peut pas être négatif");
		}
		
		$post = PostManager::getPostById($id);
		View::render('post',['post' => $post]);
	}

	static public function display(){

	}

	

}