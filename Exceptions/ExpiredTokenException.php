<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that token was valid, but has expired
 */
class ExpiredTokenException extends \Exception
{
    public $message = "Le token a expiré";
    public $code    = 401;
    public function __construct()
    {
        parent::__construct();
    }
}
