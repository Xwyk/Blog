<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Comment;
use Blog\Framework\View;

class CommentController extends Controller{
	
	public function addComment()
	{

		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new PostNotFoundException($id);
		}
		$comment = new Comment([
			'content' => filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
			'author' => $this->session->getAttribute('user'),
			'postId' => $id
		]);
		CommentManager::add($comment);
		$this->redirect('/?action=post&id='.$id);
	}

	public function validateComment(){
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new Exception("Commentaire non valide");
		}
		CommentManager::validateComment($id);
		$this->redirect('/?action=post&id='.CommentManager::getCommentById($id)->getPostId());
	}

	public function invalidateComment(){
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new Exception("Commentaire non valide");
		}
		CommentManager::invalidateComment($id);
		$this->redirect('/?action=post&id='.CommentManager::getCommentById($id)->getPostId());
	}
}