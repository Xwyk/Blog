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
}
