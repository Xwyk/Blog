<?php

namespace Blog\Framework;

use Blog\Exceptions\NotEnoughRightsException;
use Blog\Exceptions\UserNotConnectedException;
use Blog\Model\User;

/**
 *
 */
abstract class SecuredController extends Controller
{
    
    public function __construct(View $view, Session $session, Configuration $config)
    {

        parent::__construct($view, $session, $config);
    }

    public function isAdmin()
    {
        return $this->session->isAdmin();
    }

    public function isUser()
    {
        return $this->session->isAuthenticated();
    }
}
