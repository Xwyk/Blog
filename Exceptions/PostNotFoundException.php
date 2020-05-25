<?php

namespace Blog\Exceptions;

class PostNotFoundException extends \Exception{
	public $message = "Cet article n'existe pas";

	public $postId;

	public function __construct($id){
		$this->id = $id;
		parent::__construct();
	}
}