<?php

namespace Blog\Exceptions;

/**
 * Exception who tells that mail address is already used for an account
 */
class AlreadyUsedMailAddressException extends \Exception
{
    public $message = "L'adresse mail suivante est déjà utilisée : ";

    public function __construct(string $mail)
    {
        $this->message .= $mail;
        parent::__construct();
    }
}
