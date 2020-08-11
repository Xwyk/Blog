<?php

namespace Blog\Exceptions;

class WrongPasswordException extends \Exception{
    public $message = "Mot de passe incorrect";

    public function __construct(){
        parent::__construct();
    }
}