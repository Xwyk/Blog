<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that password is wrong for account
 */
class WrongPasswordException extends \Exception
{
    public $message = "Mot de passe incorrect";

    public function __construct($message = "")
    {
    	if ($message != "") {
    		$this->message = $message;
    	}
        parent::__construct();
    }
}
