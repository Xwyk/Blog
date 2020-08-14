<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that user account isn't active
 */
class UserNotActiveException extends \Exception
{
    public $message = "L'utilisateur n'est pas activé : ";

    public function __construct($user)
    {
        $this->message .= $user;
        parent::__construct();
    }
}
