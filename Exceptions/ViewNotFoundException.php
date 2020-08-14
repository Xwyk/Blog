<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that view file can't be found
 */
class ViewNotFoundException extends \Exception
{
    public $message = "La vue suivante n'a pas pu être trouvée : ";

    public function __construct($path)
    {
        $this->message .= $path;
        parent::__construct();
    }
}
