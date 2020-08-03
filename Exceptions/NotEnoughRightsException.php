<?php

namespace Blog\Exceptions;

class NotEnoughRightsException extends \Exception{
	public $message = "Droits insuffisants pour accéder à la demande";

	public function __construct($path=""){
		$this->message .= " ".$path;
		parent::__construct();
	}
}