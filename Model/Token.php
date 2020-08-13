<?php

namespace Blog\Model;

use Blog\Framework\Entity;

/**
 * Token
 */
class Token extends Entity
{

    private $user;
    private $value;
    private $generationDate;
    private $expirationDate;


    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getGenerationDate()
    {
        return $this->generationDate;
    }

    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    public function setUser(User $newUser)
    {
        $this->user = $newUser;
    }

    public function setValue(string $newValue)
    {
        $this->value = $newValue;
    }

    public function setGenerationDate($newGenerationDate)
    {
        $this->generationDate=$newGenerationDate;
    }

    public function setExpirationDate($newExpirationDate)
    {
        $this->expirationDate=$newExpirationDate;
    }
}