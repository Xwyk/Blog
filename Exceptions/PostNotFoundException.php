<?php

namespace Blog\Exceptions;

class PostNotFoundException extends \Exception{
    public $message = "L'article demandé n'existe pas";

    public $postId;

    public function __construct($id){
        $this->postId = $id;
        parent::__construct();
    }
}