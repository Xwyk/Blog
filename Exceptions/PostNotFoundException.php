<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that asked post doesn't exists
 */
class PostNotFoundException extends \Exception
{
    public $message = "L'article demandé n'existe pas";

    public $postId;

    public function __construct($id)
    {
        $this->postId = $id;
        $this->code = 404;
        parent::__construct();
    }
}
