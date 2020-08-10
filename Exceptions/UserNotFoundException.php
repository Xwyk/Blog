<?php

namespace Blog\Exceptions;

class UserNotFoundException extends \Exception{
	public $message = "Aucun compte trouvé pour";

	public function __construct(string $mail){
		$this->message .= ' : '.$mail;
		parent::__construct();
	}
}