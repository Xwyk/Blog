<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that asked post doesn't exists
 */
class CommentNotFoundException extends \Exception
{
    public $message = "Commentaire non trouvé";


    public function __construct($id)
    {
        $this->code = 404;
        parent::__construct();
    }
}
