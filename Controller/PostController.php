<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Comment;
use Blog\Framework\View;

class PostController extends Controller{
	
	public function display()
	{
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new PostNotFoundException($id);
		}
		$post = PostManager::getPostById($id);
		$this->render('post',['post' => $post, "mainTitle"=>$post->getTitle()]);
	}

	public function addComment()
	{

		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new PostNotFoundException($id);
		}
		$comment = new Comment([
			'content' => $_POST['commentText'],
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
