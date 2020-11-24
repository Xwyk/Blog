<?php

namespace Blog\Framework;

use Blog\Model\User;
use Blog\Model\Manager\TokenManager;
use Blog\Exceptions\ExpiredSessionException;

/**
 * Represents a session on the website
 */
class Session
{
    //$_SESSION associatives keys
    public const AUTHENTICATED_KEY                    = 'user';
    public const TOKEN_KEY                            = 'token';
    public const SESSION_KEY                          = 'session';
    public const SESSION_GENERATION_TIME_KEY          = 'sessionGenerationTime';
    public const SESSION_EXPIRATION_TIME_KEY          = 'sessionExpirationTime';
    public const SESSION_INACTIVITY_TIME_KEY          = 'sessionInactivityTime';
    
    //Session time validity
    protected const SESSION_VALIDITY_MINUTES          = 60;
    protected const SESSION_INACTIVITY_LOGOUT_MINUTES = 10;

    //Configuration object
    protected $config;

    protected $tokenManager;

    /**
     * Constructor. Set values.
     * Create or recover session, logout if user is connected, renew it automatically if not
     * @param Configuration $config database configuration file
     * @throws ExpiredSessionException If session is expired
     */
    public function __construct(Configuration $config)
    {
        $this->config       = $config;
        $this->tokenManager = new TokenManager($this->config);

        if (session_status() != PHP_SESSION_ACTIVE) {
            //Creating or recover session
            session_start();
            // If there is no generated session, generate it
            if (!$this->existAttribute($this::SESSION_KEY)) {
                $this->generateSession();
            }
            // If session is'nt valid
            if (!$this->checkSession()) {
                // If user is authenticated on invalid session, logout it
                if ($this->isAuthenticated()) {
                    $this->logout();
                    throw new ExpiredSessionException("Session expirée");
                }
                // If there is no user on session, regenerate it
                $this->generateSession();
            }
        }
    }

    /**
     * Authentication status
     * @return boolean true => user is connected; false => user isn't connected
     */
    public function isAuthenticated()
    {
        //Check presence of authentication key in session array
        return $this->existAttribute($this::AUTHENTICATED_KEY);
    }

    /**
     * Admin status
     * @return boolean true => admin is connected; false => user or nobody connected
     */
    public function isAdmin()
    {
        return (($this->isAuthenticated()) &&
            ($this->getAttribute($this::AUTHENTICATED_KEY)->getType() == User::TYPE_ADMIN));
    }

    /**
     * Login user in $_SESSION. Add key in array
     * @param  User $user User object to add in session
     */
    public function login(User $user)
    {
        $this->retardInactivity();
        $this->addAttribute($this::AUTHENTICATED_KEY, $user);
    }

    /**
     * Kill user session
     */
    public function logout()
    {
        if ($this->isAuthenticated()) {
            $this->tokenManager->removeForUser($this->getAttribute($this::AUTHENTICATED_KEY));
            $_SESSION = array();
        }
        session_destroy();
    }

    /**
     * Add a value at $name key in $_SESSION array
     * @param string $name  associative key
     * @param $value value to add
     */
    public function addAttribute(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Attribute existence status
     * @param  string $name Associative key to attribute
     * @return bool         Status : true => attribute exists; false => attribute doesn't exists
     */
    public function existAttribute(string $name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Get attribute associated to key
     * @param  string $name Associative key to get
     * @return value of assiociated key
     */
    public function getAttribute(string $name)
    {
        return $_SESSION[$name];
    }

    /**
     * Generate a new session
     */
    private function generateSession()
    {
        $this->addAttribute($this::SESSION_KEY, bin2hex(openssl_random_pseudo_bytes(32)));
        
        //Store session generation time, expiration time and inactivity expiration time.
        $this->addAttribute($this::SESSION_GENERATION_TIME_KEY, new \DateTime());
        
        $sessionExpiration = clone $this->getAttribute($this::SESSION_GENERATION_TIME_KEY);
        $sessionExpiration->modify('+ '.$this::SESSION_VALIDITY_MINUTES.' minutes');
        $this->addAttribute($this::SESSION_EXPIRATION_TIME_KEY, $sessionExpiration);

        $sessionInactivity = clone $this->getAttribute($this::SESSION_GENERATION_TIME_KEY);
        $sessionInactivity->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
        $this->addAttribute($this::SESSION_INACTIVITY_TIME_KEY, $sessionInactivity);
    }

    /**
     * Get a token from TokenManager. Generate a token only usable by actual user and return it
     * @return string new token
     */
    public function getToken(): string
    {
        $connectedUser = $this->getAttribute($this::AUTHENTICATED_KEY);
        return $this->tokenManager->create(32, $connectedUser);
    }

    /**
     * Check token validity for current user
     * @param  string $tokenToCheck token to check
     * @return [type]               token validity status
     */
    public function checkToken(string $tokenToCheck)
    {
        $connectedUser = $this->getAttribute($this::AUTHENTICATED_KEY);
        return $this->tokenManager->check($tokenToCheck, $connectedUser);
    }

    /**
     * Check session validity.
     * @return bool true => session is valid; false => session isn't valid
     */
    private function checkSession()
    {
        $now = new \DateTime();
        //$sessionExpiration = $this->getAttribute($this::SESSION_EXPIRATION_TIME_KEY);
        $sessionInactivity = $this->getAttribute($this::SESSION_INACTIVITY_TIME_KEY);
        // || $sessionInactivity < $now
        
        if (($sessionInactivity < $now)) {
            return false;
        }
        return true;
    }

    /**
     * Retard inactivity by SESSION_INACTIVITY_LOGOUT_MINUTES
     */
    private function retardInactivity()
    {
        //Create a new DateTime of current and add SESSION_INACTIVITY_LOGOUT_MINUTES minutes to thius time 
        $sessionInactivity = new \DateTime();
        $sessionInactivity->modify('+ '.$this::SESSION_INACTIVITY_LOGOUT_MINUTES.' minutes');
        $this->addAttribute($this::SESSION_INACTIVITY_TIME_KEY, $sessionInactivity);
    }
}
