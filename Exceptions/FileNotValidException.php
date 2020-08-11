<?php

namespace Blog\Exceptions;

class FileNotValidException extends \Exception{
    public $message = "Le fichier n'est pas valide : ";

    public function __construct($path){
        $this->message .= $path;
        parent::__construct();
    }
}