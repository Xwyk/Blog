<?php
namespace Blog\Model\Manager;
// require __DIR__.'/../../Framework/Manager.php';
// require __DIR__.'/../Post.php';

use Blog\Framework\Manager;
use Blog\Model\User;
/**
 * 
 */
class UserManager extends Manager
{
	
	static public function getUserById(int $userId) : User
	{
		$request = 'SELECT * FROM user 
					WHERE id = :id ;';
		$user = self::executeRequest($request, ['id' => $userId]);
		return new User($user->fetch());
	}
}