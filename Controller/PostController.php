<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\View\View;

class PostController extends Controller{
	
	static public function displayPostById(int $id)
	{
		if ($id<0) {
			throw new OutOfRangeException("L'ID d'un article ne peut pas être négatif");
		}
		
		$post = PostManager::getPostById($id);
		//$commentsList = self::getComments($id);

		View::render('post',['post' => $post]);
	}

	static public function display(){

	}

	static protected function getComments(int $postId)
	{
		return CommentManager::getCommentsByPost($postId);
	}

}