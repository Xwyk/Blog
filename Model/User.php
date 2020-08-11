<?php

namespace Blog\Model;

use Blog\Framework\Entity;

/**
 * summary
 */

class User extends Entity
{
    public const TYPE_USER = 1;
    public const TYPE_ADMIN = 2 ;

    private $id;
    private $creationDate;
    private $modificationDate;
    private $firstName;
    private $lastName;
    private $pseudo;
    private $mailAddress;
    private $password;
    private $active = false;
    private $type = self::TYPE_USER;

    /**
     * Construct object
     * @param array data Associative array containing values for variables
     */
    public function __construct(array $data)
    {
        $this->creationDate = new \DateTime();
        $this->modificationDate = new \DateTime();
        $this->hydrate($data);
    }

    /**
     * Return first name
     * @return string firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Return last name
     * @return string lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Return pseudo
     * @return string pseudo
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Return mail address
     * @return string mailAddress
     */
    public function getMailAddress()
    {
        return $this->mailAddress;
    }

    /**
     * Return password
     * @return string password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Return user activation state
     * @return bool active
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Return user type
     * @return string type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return id value
     * @return int id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return creationDate value
     * @return Date creationDate
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Return modificationDate value
     * @return Date modificationDate
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set id value
     * @param int newID New id to set. This can be set once
     * @throws RangeException If newID isn't bigger than 0
     * @throws Exception If newID is already set
     * @throws InvalidArgumentException If newID isn't a number
     */
    protected function setId(int $newID)
    {
        // If id is already set, throw exception
        if (isset($this->id)) {
            throw new \Exception('Can\'t change id of an object once it was set');
        }
        // If id is numeric and bigger than 0, attribute value, else throw exception
        if (is_numeric($newID)) {
            if ($newID > 0) {
                $this->id = $newID;
            } else {
                throw new \RangeException('La valeur de l\'identifiant ne pet pas être inférieure ou égale à 0');
            }
        } else {
            throw new \InvalidArgumentException('Le type de l\'argument fourni ne correspond pas à un nombre ');
        }
    }

    /**
     * Set creationDate value
     * @param Date newDate New date to set
     */
    protected function setCreationDate(string $newDate)
    {
        if (is_null($newDate)) {
            $this->creationDate="";
        } else {
            $this->creationDate = (new \DateTime())->createFromFormat('Y-m-d H:i:s', $newDate);
        }
    }

    /**
     * Set modificationDate value
     * @param Date newDate New date to set
     */
    protected function setModificationDate(string $newDate)
    {
        if (is_null($newDate)) {
            $this->creationDate="";
        } else {
            $this->modificationDate = (new \DateTime())->createFromFormat('Y-m-d H:i:s', $newDate);
        }
    }

    /**
     * Set first name
     * @param string newFirstName New first name to set
     * @throws UnexpectedValueException If newFirstName contain html or php code
     */
    protected function setFirstName(string $newFirstName)
    {
        if ($newFirstName == strip_tags($newFirstName)) {
            $this->firstName = $newFirstName;
        } else {
            throw new \UnexpectedValueException('Can\'t set firstname : value contain html/PHP code');
        }
    }

    /**
     * Set last name
     * @param string newLastName New last name to set
     * @throws UnexpectedValueException If newLastName contain html or php code
     */
    protected function setLastName(string $newLastName)
    {
        if ($newLastName == strip_tags($newLastName)) {
            $this->lastName = $newLastName;
        } else {
            throw new \UnexpectedValueException('Can\'t set lastname : value contain html/PHP code');
        }
    }

    /**
     * Set pseudo
     * @param string newPseudo New pseudo to set
     * @throws UnexpectedValueException If newPseudo contain html or php code
     */
    protected function setPseudo(string $newPseudo)
    {
        if ($newPseudo == strip_tags($newPseudo)) {
            $this->pseudo = $newPseudo;
        } else {
            throw new \UnexpectedValueException('Can\'t set pseudo : value contain html/PHP code');
        }
    }

    /**
     * Set mail address
     * @param string newMailAddress New mail address to set
     * @throws UnexpectedValueException If newMailAddress contain html or php code
     * @throws UnexpectedValueException If newMailAddress doesn't match regexp
     */
    protected function setMailAddress(string $newMailAddress)
    {
        if ($newMailAddress != strip_tags($newMailAddress)) {
            throw new \UnexpectedValueException('L\'adresse fournie contient du code');
        }
        $isValid = preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $newMailAddress);
        if (!$isValid) {
            throw new \UnexpectedValueException('L\'adresse mail n\'est pas valide');
        }
        $this->mailAddress = $newMailAddress;
    }

    /**
     * Set password
     * @param string newPassword New password to set
     * @throws UnexpectedValueException If newPassword contain html or php code
     */
    protected function setPassword(string $newPassword)
    {
        if ($newPassword != strip_tags($newPassword)) {
            throw new \UnexpectedValueException('Can\'t set password : value contain html/PHP code');
        } else {
            $this->password = $newPassword;
        }
    }

    /**
     * Set activation state
     * @param string activation New activation state to set
     */
    protected function setActive(bool $activation)
    {
        $this->active = $activation;
    }

    /**
     * Set user type
     * @throws UnexpectedValueException If newType doesn't correspond to accepted values
     */
    protected function setType(int $newType)
    {
        if ($newType == self::TYPE_USER || $newType == self::TYPE_ADMIN) {
            $this->type = $newType;
        } else {
            $this->type = self::TYPE_USER;
        }
    }
}
