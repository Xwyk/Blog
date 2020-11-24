<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that file isn't valid
 */
class ValueNotExistsException extends \Exception
{
    public $message = "La valeur demandée n'existe pas dans le fichier de configuration ";
    public $code    = 404;

    public function __construct()
    {
        parent::__construct();
    }
}
