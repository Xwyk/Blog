<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\User;
/**
 * 
 */
class UserManager extends Manager
{
	/**
	 * 
	 */	
	static public function getUserById(int $userId) : User
	{
		$request = 'SELECT * FROM user 
					WHERE id = :id ;';
		$user = self::executeRequest($request, ['id' => $userId]);
		return new User($user->fetch());
	}

	static public function getUserByMail(string $userMail)
	{
		$request = 'SELECT * FROM user 
					WHERE mail_address = :mail ;';
		$user = self::executeRequest($request, [':mail' => $userMail]);
		$user = $user->fetch();
		if ($user) {
			$user = new User($user);	
		}
		return $user;
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
		if (!$user->getActive()) {
			throw new \Exception("Le compte utilisateur n'est pas activé", 1);
		}
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

	static public function add($userToAdd)
	{
		if(self::getUserByMail($userToAdd->getMailAddress())){
		 	throw new \Exception("Adresse mail déjà utilisée", 1);
		}
		$request = 'INSERT INTO user (first_name, 
									  last_name,
									  pseudo,
									  mail_address,
									  password)
					VALUES (:firstname, 
							:lastname, 
							:pseudo, 
							:mail, 
							:pwd);';
		$result = self::executeRequest($request, [
			':firstname'=>$userToAdd->getFirstName(), 
			':lastname' => $userToAdd->getLastName(), 
			':pseudo' => $userToAdd->getPseudo(), 
			':mail' => $userToAdd->getMailAddress(), 
			':pwd' => password_hash($userToAdd->getPassword(), PASSWORD_DEFAULT)]);
		return $result;				    
	}
}

