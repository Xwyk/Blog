<?php

namespace Blog\Framework;
use Blog\Model\User;
/**
 * 
 */
class Session
{
	const AUTHENTICATED_KEY = 'user';
	const TOKEN_VALIDITY_MINUTES = -1;
	private $token;
	private $tokenGeneration;
	public function __construct()
	{	
		if(!isset($_SESSION)){
			session_start();
			$this->generateToken();
			
		}
	}

	public function isAuthenticated()
	{
		return $this->existAttribute(self::AUTHENTICATED_KEY);
	}

	public function isAdmin()
	{
		return $this->isAuthenticated() && 
			   $this->getAttribute(self::AUTHENTICATED_KEY)->getType() == User::TYPE_ADMIN;
	}

	public function login($user)
	{
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

	private function generateToken()
	{
		$this->token = bin2hex(openssl_random_pseudo_bytes(32));
		$this->tokenGeneration = new \DateTime();
	}

	private function checkToken(string $tokenToCheck)
	{
		if (!$this->token==$tokenToCheck) {
			throw new Exception("Token invalide", 1);
		}
		$expirationDate = $this->tokenGeneration;
		$expirationDate->modify('+'.$this::TOKEN_VALIDITY_MINUTES.'minutes');
		if (!$expirationDate>new \DateTime()) {
			throw new Exception("Token trop ancien", 1);
		}
		return true;
	}
}