<?php

namespace Blog\Controller;
use Blog\Framework\Controller;
use Blog\Model\Manager\CommentManager;
use Blog\Framework\Configuration;
use Blog\Framework\Session;
use Blog\Framework\View;
use Blog\Exceptions\NotEnoughRightsException;
class AdminController extends Controller{

	public function display()
	{
		if (!$this->isAdmin()) {
			if (!$this->isUser()) {
				$this->redirect($this::URL_LOGIN);
			}
			throw new \NotEnoughRightsException();
		}
		$this->render($this::VIEW_ADMIN, [
			'comments' => $this->getAllComments(),
			'token'    => $this->getToken()
		]);
	}

	protected function getAllInvalidComments()
	{
		return (new CommentManager($this->config))->getAllInvalidComments();
	}

	protected function getAllComments()
	{
		return (new CommentManager($this->config))->getAllComments();
	}

	protected function getAllUsers()
	{
		//return (new CommentManager($this->config))->getAllInvalidComments();
	}

	protected function getAdminUsers()
	{
		//return (new CommentManager($this->config))->getAllInvalidComments();
	}

	protected function getNonAdminUsers()
	{
		//return (new CommentManager($this->config))->getAllInvalidComments();
	}
}
