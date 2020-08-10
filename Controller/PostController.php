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
		if (!$this->isAdmin()) {
			if (!$this->isUser()) {
				$this->redirect($this::URL_LOGIN);
			}
			throw new \Exception("Les droits administrateur sont nécéssaires", 1);
		}
		$validate = filter_input(INPUT_POST, 'validate',FILTER_VALIDATE_INT);
		if (!$validate) {
			$this->render($this::VIEW_ADDPOST);
			return;
		}
		
		$newpost = (new PostManager($this->config))->createFromArray([
			'postTitle'=>filter_input(INPUT_POST, 'postTitle',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
			'postChapo'=>filter_input(INPUT_POST, 'postChapo',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
			'postContent'=>filter_input(INPUT_POST, 'postContent',FILTER_SANITIZE_FULL_SPECIAL_CHARS),
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
