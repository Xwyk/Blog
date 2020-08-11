<?php

namespace Blog\Exceptions;

class AlreadyUsedMailAddressException extends \Exception
{
    public $message = "L'adresse mail suivante est déjà utilisée : ";

    public function __construct(string $mail)
    {
        $this->message .= $mail;
        parent::__construct();
    }
}
