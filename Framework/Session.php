<?php

namespace Blog\Framework;
use Blog\Model\User;
/**
 * 
 */
class Session
{
	const AUTHENTICATED_KEY = 'user';
	const TOKEN_VALIDITY_MINUTES = 10;
	const SESSION_VALIDITY_MINUTES = 60;
	const SESSION_INACTIVITY_LOGOUT_MINUTES = 20;
	const TOKEN_KEY = 'token';
	const SESSION_KEY = 'session';

	const TOKEN_EXPIRATED = 4;
	const TOKEN_NOT_GENERATED = 3;
	const TOKEN_INVALID = 2;
	const TOKEN_VALID = 1;

	const TOKEN_GENERATION_TIME_KEY = 'tokenGenerationTime';
	const TOKEN_EXPIRATION_TIME_KEY = 'tokenExpirationTime';
	const SESSION_GENERATION_TIME_KEY = 'sessionGenerationTime';
	const SESSION_EXPIRATION_TIME_KEY = 'sessionExpirationTime';
	const SESSION_INACTIVITY_TIME_KEY = 'sessionInactivityTime';
	public function __construct()
	{	
		if(session_status() != PHP_SESSION_ACTIVE){
			//Création ou récupération d'une session
			session_start();
			if (!$this->existAttribute(self::SESSION_KEY)) {
				$this->generateSession();
			}
			if (!$this->checkSession()) {
				$this->logout();
				throw new \Exception("Session expirée");
			}
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
		$this->retardInactivity();
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

	private function generateSession()
	{
		$this->addAttribute(self::SESSION_GENERATION_TIME_KEY, new \DateTime());
		$this->addAttribute(self::SESSION_KEY, bin2hex(openssl_random_pseudo_bytes(32)));
		$sessionExpirationTime = clone $this->getAttribute(self::SESSION_GENERATION_TIME_KEY);
		$sessionExpirationTime->modify('+ '.$this::SESSION_VALIDITY_MINUTES.' minutes');
		$this->addAttribute(self::SESSION_EXPIRATION_TIME_KEY, $sessionExpirationTime);

		$sessionInactivityTime = clone $this->getAttribute(self::SESSION_GENERATION_TIME_KEY);
		$sessionInactivityTime->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
		$this->addAttribute(self::SESSION_INACTIVITY_TIME_KEY, $sessionInactivityTime);

	}

	public function getToken() : string
	{

		$this->addAttribute(self::TOKEN_KEY, bin2hex(openssl_random_pseudo_bytes(32)));
		$this->addAttribute(self::TOKEN_GENERATION_TIME_KEY, new \DateTime());

		$tokenExpirationTime = clone $this->getAttribute(self::TOKEN_GENERATION_TIME_KEY);
		$tokenExpirationTime->modify('+ '.$this::TOKEN_VALIDITY_MINUTES.' minutes');
		$this->addAttribute(self::TOKEN_EXPIRATION_TIME_KEY, $tokenExpirationTime);

		return $this->getAttribute(self::TOKEN);
	}

	public function checkToken(string $tokenToCheck) : bool
	{
		if (!$this->existAttribute(self::TOKEN_KEY)) {
			return self::TOKEN_NOT_GENERATED;
		}
		if ($this->getAttribute(self::TOKEN_KEY) != $tokenToCheck) {
			return self::TOKEN_INVALID;
		}
		if ($this->getAttribute(self::TOKEN_EXPIRATION_TIME_KEY) < new \DateTime()) {
			return self::TOKEN_EXPIRATED;
		}
		return self::TOKEN_VALID;
	}

	private function checkSession()
	{
		$now = new \DateTime();
		if (!($this->getAttribute(self::SESSION_EXPIRATION_TIME_KEY) > $now || $this->getAttribute(self::SESSION_INACTIVITY_TIME_KEY) > $now)) {
			return false;
		}
		return true;
	}

	private function retardInactivity()
	{
		$sessionInactivityTime = new \DateTime();
		$sessionInactivityTime->modify('+ '.self::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
		$this->addAttribute(self::SESSION_INACTIVITY_TIME_KEY, $sessionInactivityTime);
	}
}