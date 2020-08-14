<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that token isn't valid
 */
class InvalidTokenException extends \Exception
{
    public $message = "Le token n'est pas valide";

    public function __construct()
    {
        parent::__construct();
    }
}
