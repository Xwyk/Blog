<?php

namespace Blog\Exceptions;

class ViewNotFoundException extends \Exception
{
    public $message = "La vue suivante n'a pas pu être trouvée : ";

    public function __construct($path)
    {
        $this->message .= $path;
        parent::__construct();
    }
}
