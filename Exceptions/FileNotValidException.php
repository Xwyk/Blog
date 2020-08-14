<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that file isn't valid
 */
class FileNotValidException extends \Exception
{
    public $message = "Le fichier n'est pas valide : ";

    public function __construct($path)
    {
        $this->message .= $path;
        parent::__construct();
    }
}
