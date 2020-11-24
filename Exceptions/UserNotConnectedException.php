<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that user isn't connected
 */
class UserNotConnectedException extends \Exception
{
    public $message = "Utilisateur non connecté";
    public $code    = 401;
    public function __construct()
    {
        parent::__construct();
    }
}
