<?php

namespace Blog\Exceptions;

class FileNotFoundException extends \Exception{
    public $message = "Le fichier suivant n'a pas pu être trouvé : ";

    public function __construct($path){
        $this->message .= $path;
        parent::__construct();
    }
}