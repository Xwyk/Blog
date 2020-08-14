<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that user can't be found
 */
class UserNotFoundException extends \Exception
{
    public $message = "Aucun compte trouvé pour";

    public function __construct(string $mail)
    {
        $this->message .= ' : '.$mail;
        parent::__construct();
    }
}
