<?php

namespace Blog\Controller;
use Blog\Framework\SecuredController;
use Blog\Model\Manager\CommentManager;
use Blog\Framework\Configuration;
use Blog\Framework\Session;
use Blog\Framework\View;
class AdminController extends SecuredController{

	public function display()
	{
		if (!$this->session->existAttribute('user') || !$this->session->getAttribute('user')->getType()==2) {
			throw new \Exception('Utilisateur non connecté');
		}
		$this->render($this::VIEW_ADMIN, ['comments' => $this->getAllComments()]);

	}

	protected function getAllInvalidComments()
	{
		return CommentManager::getAllInvalidComments();
	}

	protected function getAllComments()
	{
		return (new CommentManager($this->config))->getAllComments();
	}

	protected function getAllUsers()
	{
		return CommentManager::getAllInvalidComments();
	}

	protected function getAdminUsers()
	{
		return CommentManager::getAllInvalidComments();
	}

	protected function getNonAdminUsers()
	{
		return CommentManager::getAllInvalidComments();
	}
}
