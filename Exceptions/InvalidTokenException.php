<?php

namespace Blog\Exceptions;

class InvalidTokenException extends \Exception
{
    public $message = "Le token n'est pas valide";

    public function __construct()
    {
        parent::__construct();
    }
}
