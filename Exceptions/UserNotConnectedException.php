<?php

namespace Blog\Exceptions;

class UserNotConnectedException extends \Exception{
	public $message = "Utilisateur non connecté";

	public function __construct(){
		parent::__construct();
	}
}