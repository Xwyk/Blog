<?php

namespace Blog\Controller;
// require __DIR__."/../View/View.php";
use Blog\Framework\Controller;
use Blog\Model\Manager\CommentManager;

class AdminController extends Controller{
	
	public function display()
	{
		if (!$this->session->existAttribute('user') || !$this->session->getAttribute('user')->getType()==2) {
			throw new \Exception('Utilisateur non connecté');
		}
		$this->render('admin', ['invalidComments' => $this->getAllInvaliComments()]);

	}

	public function getAllInvaliComments()
	{
		return CommentManager::getAllInvalidComments();
	}

	public function getAllUsers()
	{
		return CommentManager::getAllInvalidComments();
	}

	public function getAdminUsers()
	{
		return CommentManager::getAllInvalidComments();
	}

	public function getNonAdminUsers()
	{
		return CommentManager::getAllInvalidComments();
	}
}
