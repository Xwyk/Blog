<?php

namespace Blog\Exceptions;

class MoveImageException extends \Exception
{
    public $message = "Impossible de déplacer l'image";

    public function __construct($path = "")
    {
        $this->message .= " ".$path;
        parent::__construct();
    }
}
