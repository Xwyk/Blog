<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that Session has expired
 */
class ExpiredSessionException extends \Exception
{
    public $message = "La session a expiré";
    public $code	= 403; 
    public function __construct()
    {
        parent::__construct();
    }
}
