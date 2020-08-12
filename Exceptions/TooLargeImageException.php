<?php

namespace Blog\Exceptions;

class TooLargeImageException extends \Exception
{
    public $message = "L'image est trop grande";

    public function __construct($path = "")
    {
        $this->message .= " ".$path;
        parent::__construct();
    }
}
