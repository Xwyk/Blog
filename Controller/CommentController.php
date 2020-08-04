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

		$postId = filter_input(INPUT_GET, 'postId',FILTER_VALIDATE_INT);
		if ($postId == false) {
			throw new PostNotFoundException($postId);
		}
		$comment = new Comment([
			'content' => filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
			'author' => $this->session->getAttribute('user'),
			'postId' => $postId
		]);
		(new CommentManager($this->config))->add($comment);
		$this->redirect($this::URL_POST.$postId);
	}

	public function validateComment(){
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new Exception("Commentaire non valide");
		}
		(new CommentManager($this->config))->validateComment($id);
		$this->redirect($this::URL_POST.(new CommentManager($this->config))->getCommentById($id)->getPostId());
	}

	public function invalidateComment(){
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new Exception("Commentaire non valide");
		}
		(new CommentManager($this->config))->invalidateComment($id);
		$this->redirect($this::URL_POST.(new CommentManager($this->config))->getCommentById($id)->getPostId());
	}
}