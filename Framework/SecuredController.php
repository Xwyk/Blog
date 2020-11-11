<?php

namespace Blog\Framework;

use Blog\Exceptions\UserNotConnectedException;

/**
 * Represent a secured controller, admin or user rights are required for create object
 */
abstract class SecuredController extends Controller
{
    /**
     * Constructor. Check if user is connected. If no connection, throw exception
     * @param View          $view    Templating engine
     * @param Session       $session Session object
     * @param Configuration $config  Configuraiton object
     */
    public function __construct(View $view, Session $session, Configuration $config, Router $router)
    {
        //If no user is authenticated, throw exception
        if (!$session->isAuthenticated()) {
            throw new UserNotConnectedException();
        }
        //Call Controller constructor
        parent::__construct($view, $session, $config, $router);
    }

    /**
     * Check admin rights
     * @throws NotEnoughRightsException if user isn't admin
     */
    public function checkAdminRights()
    {
        //Throws exception if iser isn't admin
        if (!$this->isAdmin()) {
            throw new NotEnoughRightsException();
        }
    }

    /**
     * Check user rights
     * @throws NotConnectedUserException if user isn't connected
     */
    public function checkUserRights()
    {
        //Throws exception if iser isn't admin
        if (!$this->isUser()) {
            throw new NotConnectedUserException();
        }
    }

        /**
     * Admin rights status
     * @return boolean true => user is admin; false => user isn't admin or isn't onnected
     */
    public function isAdmin(): bool
    {
        return $this->session->isAdmin();
    }

    /**
     * User rights status
     * @return boolean true => user is connected, can be admin; false => user isn't connected
     */
    public function isUser(): bool
    {
        return $this->session->isAuthenticated();
    }

    /**
     * Get a new token
     * @return string Token to use
     */
    public function getToken(): string
    {
        return $this->session->getToken($this->config);
    }

    /**
     * Checks token validity
     * @param  string $tokenToCheck Token value to check
     * @return int                  Check status
     */
    public function checkToken(string $tokenToCheck): int
    {
        return $this->session->checkToken($tokenToCheck, $this->config);
    }
}
