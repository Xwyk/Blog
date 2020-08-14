<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that image size is too big
 */
class TooLargeImageException extends \Exception
{
    public $message = "L'image est trop grande";

    public function __construct($path = "")
    {
        $this->message .= " ".$path;
        parent::__construct();
    }
}
