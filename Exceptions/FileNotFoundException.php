<?php

namespace Blog\Exceptions;

class FileNotFoundException extends \Exception{
	public $message = "Le fichier n'existe pas : ";

	public function __construct($path){
		$this->message .= $path;
		parent::__construct();
	}
}