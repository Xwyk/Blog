<?php

namespace Blog\Exceptions;

class ExpiredSessionException extends \Exception{
    public $message = "La session a expiré";

    public function __construct(){
        parent::__construct();
    }
}