<?php

namespace Blog\Framework;

use Blog\Model\User;
use Blog\Model\Manager\TokenManager;
use Blog\Exceptions\ExpiredSessionException;

/**
 *
 */
class Session
{
    public const AUTHENTICATED_KEY = 'user';

    protected const SESSION_VALIDITY_MINUTES = 60;
    protected const SESSION_INACTIVITY_LOGOUT_MINUTES = 10;
    public const TOKEN_KEY = 'token';
    public const SESSION_KEY = 'session';

    public const SESSION_GENERATION_TIME_KEY = 'sessionGenerationTime';
    public const SESSION_EXPIRATION_TIME_KEY = 'sessionExpirationTime';
    public const SESSION_INACTIVITY_TIME_KEY = 'sessionInactivityTime';

    protected $config;
    protected $tokenManager;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
        $this->tokenManager = new TokenManager($this->config);

        if (session_status() != PHP_SESSION_ACTIVE) {
            //Création ou récupération d'une session
            session_start();
            // If there is no generated session
            if (!$this->existAttribute($this::SESSION_KEY)) {
                $this->generateSession();
            }
            // If session is'nt valid
            if (!$this->checkSession()) {
                // If user is authenticated on invalid session, kill it
                if ($this->isAuthenticated()) {
                    $this->logout();
                    throw new ExpiredSessionException("Session expirée");
                }
                // If there is no user on session, regenerate it
                $this->generateSession();
            }
        }
    }

    public function isAuthenticated()
    {
        return $this->existAttribute($this::AUTHENTICATED_KEY);
    }

    public function isAdmin()
    {
        return (($this->isAuthenticated()) &&
            ($this->getAttribute($this::AUTHENTICATED_KEY)->getType() == User::TYPE_ADMIN));
    }

    public function login($user)
    {
        $this->retardInactivity();
        $this->addAttribute($this::AUTHENTICATED_KEY, $user);
    }

    public function logout()
    {
        if ($this->isAuthenticated()) {
            $this->tokenManager->removeForUser($this->getAttribute($this::AUTHENTICATED_KEY));
            $_SESSION = array();
        }
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
        $sessionExpiration = clone $this->getAttribute($this::SESSION_GENERATION_TIME_KEY);
        $sessionExpiration->modify('+ '.$this::SESSION_VALIDITY_MINUTES.' minutes');
        $this->addAttribute($this::SESSION_EXPIRATION_TIME_KEY, $sessionExpiration);

        $sessionInactivity = clone $this->getAttribute($this::SESSION_GENERATION_TIME_KEY);
        $sessionInactivity->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
        $this->addAttribute($this::SESSION_INACTIVITY_TIME_KEY, $sessionInactivity);
    }

    public function getToken(): string
    {
        $connectedUser = $this->getAttribute($this::AUTHENTICATED_KEY);
        return $this->tokenManager->createToken(32, $connectedUser);
    }

    public function checkToken(string $tokenToCheck)
    {
        $connectedUser = $this->getAttribute($this::AUTHENTICATED_KEY);
        return $this->tokenManager->checkToken($tokenToCheck, $connectedUser);
    }

    private function checkSession()
    {
        $now = new \DateTime();
        $sessionExpiration = $this->getAttribute($this::SESSION_EXPIRATION_TIME_KEY);
        $sessionInactivity = $this->getAttribute($this::SESSION_INACTIVITY_TIME_KEY);
        // || $sessionInactivity < $now
        
        if (($sessionInactivity < $now)) {
            return false;
        }
        return true;
    }

    private function retardInactivity()
    {
        $sessionInactivity = new \DateTime();
        $sessionInactivity->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
        $this->addAttribute($this::SESSION_INACTIVITY_TIME_KEY, $sessionInactivity);
    }
}
