<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that file can't be found. Doesn't exists or unreachable
 */
class FileNotFoundException extends \Exception
{
    public $message = "Le fichier suivant n'a pas pu être trouvé : ";

    public function __construct($path)
    {
        $this->message .= $path;
        $this->code     = 404;
        parent::__construct();
    }
}
