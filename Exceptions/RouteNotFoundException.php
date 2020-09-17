<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that asked post doesn't exists
 */
class RouteNotFoundException extends \Exception
{
    public $message = "La route demandée n'existe pas";


    public function __construct()
    {
        $this->code = 404;
        parent::__construct();
    }
}
