<?php

namespace Blog\Framework;
use Blog\Model\User;
/**
 * 
 */
class Session
{
	const AUTHENTICATED_KEY = 'user';

	const SESSION_VALIDITY_MINUTES = 60;
	const SESSION_INACTIVITY_LOGOUT_MINUTES = 20;
	const TOKEN_KEY = 'token';
	const SESSION_KEY = 'session';

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
		$this->addAttribute($this::TOKEN_KEY, new Token(32));

		return $this->token->getTokenValue();
	}

	public function checkToken(string $tokenToCheck)
	{
		return $this->getAttribute($this::TOKEN_KEY)->checkToken($tokenToCheck);
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