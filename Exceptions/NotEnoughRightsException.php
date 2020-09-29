<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that current user hasn't engough rights to eccess demand
 */
class NotEnoughRightsException extends \Exception
{
    public $message = "Droits insuffisants pour accéder à la demande";
    public $code 	= 403;
    public function __construct($path = "")
    {
        $this->message .= " ".$path;
        parent::__construct();
    }
}
