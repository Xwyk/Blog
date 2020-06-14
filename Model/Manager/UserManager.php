<?php
namespace Blog\Model\Manager;

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

	static public function login(string $usermail, string $password)
	{
		$request = 'SELECT * FROM user 
					WHERE mail_address = :mailAddress ;';
		$user = self::executeRequest($request, [':mailAddress' => $usermail]);
		$result=$user->fetch();
		if (!is_array($result)) {
		 	throw new \Exception("Aucun compte trouvé", 1);
		} 
		$user = new User($result);
		if (!password_verify($password,$user->getPassword())) {
			throw new \Exception("Mot de passe incorrect", 1);
		}
		return $user;
	}

	static public function createFromArray(array $data)
	{
		return new User([
					'id' => $data['userId'],
					'pseudo' => $data['userPseudo'],
					'first_name' => $data['userFirstName'],
					'last_name' => $data['userLastName'],
					'mail_address' => $data['userMailAddress']
				]);
	}

	static public function add(User $user)
	{
		$request = 'INSERT INTO user (chapo, 
									  title,
									  content,
									  author)
					VALUES (:chapo, 
							:title, 
							:content, 
							:author);';
		var_dump($user);
		// $result = self::executeRequest($request, []);
		// return $result;				    
	}
}