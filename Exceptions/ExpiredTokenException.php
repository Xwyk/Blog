<?php

namespace Blog\Exceptions;

class ExpiredTokenException extends \Exception{
	public $message = "Le token a expiré";

	public function __construct(){
		parent::__construct();
	}
}