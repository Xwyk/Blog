<?php

namespace Blog\Framework;
use Blog\Model\User;
/**
 * 
 */
class Session
{
	const AUTHENTICATED_KEY = 'user';

	public function __construct()
	{	
		if(!isset($_SESSION)){
			session_start();
		}
	}


	public function isAuthenticated(){
		return $this->existAttribute(self::AUTHENTICATED_KEY);
	}

	public function isAdmin(){
		return ($this->isAuthenticated()) && ($this->getAttribute(self::AUTHENTICATED_KEY)->getType() == User::TYPE_ADMIN);
	}

	public function login($user){
		$this->addAttribute(self::AUTHENTICATED_KEY, $user);
	}

	public function logout()
	{	
		session_destroy();
	}

	public function addAttribute(string $name, $value)
	{
		$_SESSION[$name] = $value;
	}

	public function existAttribute(string $name)
	{
		return isset($_SESSION[$name]);
	}

	public function getAttribute(string $name)
	{
		return $_SESSION[$name];
	}
}