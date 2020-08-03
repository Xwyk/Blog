<?php

namespace Blog\Controller;
// require __DIR__."/../View/View.php";
use Blog\Framework\SecuredController;
use Blog\Model\Manager\CommentManager;

class AdminController extends SecuredController{
	
	public function display()
	{
		if (!$this->session->existAttribute('user') || !$this->session->getAttribute('user')->getType()==2) {
			throw new \Exception('Utilisateur non connecté');
		}
		$this->render('admin', ['comments' => $this->getAllComments()]);

	}

	protected function getAllInvalidComments()
	{
		return CommentManager::getAllInvalidComments();
	}

	protected function getAllComments()
	{
		return CommentManager::getAllComments();
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
