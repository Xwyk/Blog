<?php

namespace Blog\Exceptions;

class UserNotActiveException extends \Exception{
    public $message = "L'utilisateur n'est pas activé : ";

    public function __construct($user){
        $this->message .= $user;
        parent::__construct();
    }
}