<?php

namespace Blog\Framework;

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
		if($this->existAttribute(self::AUTHENTICATED_KEY)){
			return$this->getAttribute(self::AUTHENTICATED_KEY); 
		}


		return false;
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