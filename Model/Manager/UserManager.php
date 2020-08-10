<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\User;
use Blog\Exceptions\UserNotActiveException;
use Blog\Exceptions\WrongPasswordException;
use Blog\Exceptions\UserNotFoundException;
use Blog\Exceptions\AlreadyUsedMailAddressException;
/**
 * 
 */
class UserManager extends Manager
{
	/**
	 * 
	 */	
	public function getUserById(int $userId) : User
	{
		$request = 'SELECT * FROM user 
					WHERE id = :id ;';
		$user = $this->executeRequest($request, ['id' => $userId]);
		return new User($user->fetch());
	}

	public function getUserByMail(string $userMail)
	{
		$request = 'SELECT * FROM user 
					WHERE mail_address = :mail ;';
		$requestResult = $this->executeRequest($request, [':mail' => $userMail]);
		$userResult = $requestResult->fetch();
		if ($userResult) {
			$user = new User($userResult);	
		}
		return $user;
	}

	public function login(string $usermail, string $password)
	{
		$request = 'SELECT * FROM user 
					WHERE mail_address = :mailAddress ;';
		$user = $this->executeRequest($request, [':mailAddress' => $usermail]);
		$result=$user->fetch();
		if (!is_array($result)) {
		 	throw new UserNotFoundException($usermail);
		}
		$user = new User($result);
		if (!$user->getActive()) {
			throw new UserNotActiveException($user->getMailAddress());
		}
		if (!password_verify($password,$user->getPassword())) {
			throw new WrongPasswordException("Mot de passe incorrect", 1);
		}
		return $user;
	}

	public function createFromArray(array $data)
	{
		return new User([
			'id'           => $data['userId'],
			'pseudo'       => $data['userPseudo'],
			'first_name'   => $data['userFirstName'],
			'last_name'    => $data['userLastName'],
			'mail_address' => $data['userMailAddress']
		]);
	}

	public function add($userToAdd)
	{
		if($this->getUserByMail($userToAdd->getMailAddress())){
		 	throw new AlreadyUsedMailAddressException($userToAdd->getMailAddress());
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
		$result = $this->executeRequest($request, [
			':firstname' =>$userToAdd->getFirstName(), 
			':lastname'  => $userToAdd->getLastName(), 
			':pseudo'    => $userToAdd->getPseudo(), 
			':mail'      => $userToAdd->getMailAddress(), 
			':pwd'       => password_hash($userToAdd->getPassword(), PASSWORD_DEFAULT)]);
		return $result;				    
	}
}

