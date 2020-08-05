<?php

namespace Blog\Framework;
use Blog\Model\User;
/**
 * 
 */
class Session
{
	const AUTHENTICATED_KEY = 'user';
	const TOKEN_VALIDITY_MINUTES = 1;
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
			if (!$this->existAttribute($this::SESSION_KEY)) {
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
		return $this->existAttribute($this::AUTHENTICATED_KEY);
	}

	public function isAdmin()
	{
		return $this->isAuthenticated() && 
			   $this->getAttribute($this::AUTHENTICATED_KEY)->getType() == User::TYPE_ADMIN;
	}

	public function login($user)
	{
		$this->retardInactivity();
		$this->addAttribute($this::AUTHENTICATED_KEY, $user);
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
		$this->addAttribute($this::SESSION_GENERATION_TIME_KEY, new \DateTime());
		$this->addAttribute($this::SESSION_KEY, bin2hex(openssl_random_pseudo_bytes(32)));
		$sessionExpirationTime = clone $this->getAttribute($this::SESSION_GENERATION_TIME_KEY);
		$sessionExpirationTime->modify('+ '.$this::SESSION_VALIDITY_MINUTES.' minutes');
		$this->addAttribute($this::SESSION_EXPIRATION_TIME_KEY, $sessionExpirationTime);

		$sessionInactivityTime = clone $this->getAttribute($this::SESSION_GENERATION_TIME_KEY);
		$sessionInactivityTime->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
		$this->addAttribute($this::SESSION_INACTIVITY_TIME_KEY, $sessionInactivityTime);

	}

	public function getToken() : string
	{

		$this->addAttribute($this::TOKEN_KEY, bin2hex(openssl_random_pseudo_bytes(32)));

		$this->addAttribute($this::TOKEN_GENERATION_TIME_KEY, new \DateTime());

		$tokenExpirationTime = clone $this->getAttribute($this::TOKEN_GENERATION_TIME_KEY);
		$tokenExpirationTime->modify('+ '.$this::TOKEN_VALIDITY_MINUTES.' minutes');
		$this->addAttribute($this::TOKEN_EXPIRATION_TIME_KEY, $tokenExpirationTime);

		return $this->getAttribute($this::TOKEN_KEY);
	}

	public function checkToken(string $tokenToCheck) : int
	{
		if (!$this->existAttribute($this::TOKEN_KEY)) {
			return $this::TOKEN_NOT_GENERATED;
		}
		if ($this->getAttribute($this::TOKEN_KEY) != $tokenToCheck) {
			return $this::TOKEN_INVALID;
		}
		if ($this->getAttribute($this::TOKEN_EXPIRATION_TIME_KEY) < new \DateTime()) {
			return $this::TOKEN_EXPIRATED;
		}
		return $this::TOKEN_VALID;
	}

	private function checkSession()
	{
		$now = new \DateTime();
		if (!($this->getAttribute($this::SESSION_EXPIRATION_TIME_KEY) > $now || $this->getAttribute($this::SESSION_INACTIVITY_TIME_KEY) > $now)) {
			return false;
		}
		return true;
	}

	private function retardInactivity()
	{
		$sessionInactivityTime = new \DateTime();
		$sessionInactivityTime->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
		$this->addAttribute($this::SESSION_INACTIVITY_TIME_KEY, $sessionInactivityTime);
	}
}