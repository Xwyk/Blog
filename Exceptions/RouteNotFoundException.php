<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that asked post doesn't exists
 */
class RouteNotFoundException extends \Exception
{
    public $message = "La route demandée n'existe pas ";


    public function __construct(string $message = "")
    {
        $this->code = 400;
        $this->message.=$message;
        parent::__construct();
    }
}
