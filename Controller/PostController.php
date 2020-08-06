<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Comment;
use Blog\Framework\View;
use Blog\Framework\Configuration;
use Blog\Framework\Session;

class PostController extends Controller{
	

	public function display()
	{
		$id = filter_input(INPUT_GET, 'id',FILTER_VALIDATE_INT);
		if ($id == false) {
			throw new PostNotFoundException($id);
		}
		$post = (new PostManager($this->config))->getPostById($id);
		$this->render($this::VIEW_POST,['post' => $post, "mainTitle"=>$post->getTitle()]);
	}

	public function addPost()
	{
		if (!$this->session->existAttribute('user') || !$this->session->getAttribute('user')->getType()==2) {
			throw new \Exception('Utilisateur non connecté');
		}
		$validate = filter_input(INPUT_POST, 'validate',FILTER_VALIDATE_INT);
		if (!$validate) {
			$this->render($this::VIEW_ADDPOST);
			return;
		}
		var_dump($_FILES['postImage']);
		$newpost = (new PostManager($this->config))->createFromArray([
			'postTitle'=>$_POST['postTitle'],
			'postChapo'=>$_POST['postChapo'],
			'postContent'=>$_POST['postContent'],
			'userId'=>$this->session->getAttribute('user')->getId(),
			'userPseudo'=>$this->session->getAttribute('user')->getPseudo(),
			'userFirstName'=>$this->session->getAttribute('user')->getFirstName(),
			'userLastName'=>$this->session->getAttribute('user')->getLastName(),
			'userMailAddress'=>$this->session->getAttribute('user')->getMailAddress()
		]);
		(new PostManager($this->config))->add($newpost);
		//$this->redirect(self::URL_HOME);
	}

}
