<?php
namespace Blog\Model;
/**
 * summary
 */

class User
{
    private $id;
    private $creationDate;
    private $modificationDate;
	private $firstName;
	private $lastName;
	private $pseudo;
	private $mailAddress;
	private $password;
	private $isActive;
	private $type;

    /**
     * Construct object
     * @param array data Associative array containing values for variables
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Hydrate object by setting values passed by an array. Doesn't affect directly variables, passing by setters
     * @param array data Associative array containing values for variables
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value){
            // If db's attribute name contains '_', split name
            if (strpos($key, "_")) {
                $keyName = explode("_", $key);
                $method = 'set';
                for ($i=0; $i < count($keyName); $i++) { 
                    $method.=ucfirst($keyName[$i]);
                }
            }else
                $method = 'set'.ucfirst($key);
            // If value isn't null and method exists, call the setter
            if (!is_null($value))
                if (method_exists($this, $method))
                    $this->$method($value);
            
        }
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
     * @return bool isActive
     */
    public function getIsActive()
    {
    	return $this->isActive;
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
    public function getID(){
        return $this->id;
    }

    /**
     * Return creationDate value
     * @return Date creationDate
     */
    public function getCreationDate(){
        return $this->creationDate;
    }

    /**
     * Return modificationDate value
     * @return Date modificationDate
     */
    public function getModificationDate(){
        return $this->modificationDate;
    }

    /**
     * Set id value
     * @param int newID New id to set. This can be set once
     * @throws RangeException If newID isn't bigger than 0
     * @throws Exception If newID is already set
     * @throws InvalidArgumentException If newID isn't a number
     */
    protected function setID(int $newID){
        // If id is already set, throw exception
        if (isset($this->id))
            throw new Exception('Can\'t change id of an object once it was set');
        // If id is numeric and bigger than 0, attribute value, else throw exception
        if (is_numeric($newID))
            if ($newID > 0)
                $this->id = $newID;
            else
                throw new RangeException('La valeur de l\'identifiant ne pet pas être inférieure ou égale à 0');
        else
            throw new InvalidArgumentException('Le type de l\'argument fourni ne correspond pas à un nombre ');
    }

    /**
     * Set creationDate value
     * @param Date newDate New date to set
     */
    protected function setCreationDate(string $newDate){
        if (is_null($newDate))
            $this->creationDate="";
        
        else
            $this->creationDate = \DateTime::createFromFormat('Y-m-d H:i:s', $newDate);
        
    }

    /**
     * Set modificationDate value
     * @param Date newDate New date to set
     */
    protected function setModificationDate(string $newDate){
        if (is_null($newDate))
            $this->creationDate="";
        else
            $this->modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s', $newDate);
        
    }

    /**
     * Set first name
     * @param string newFirstName New first name to set
     * @throws UnexpectedValueException If newFirstName contain html or php code
     */
    private function setFirstName(string $newFirstName)
    {
    	if ($newFirstName == strip_tags($newFirstName))
    		$this->firstName = $newFirstName;
    	else
    		throw new UnexpectedValueException('Can\'t set firstname : value contain html/PHP code');
    }

    /**
     * Set last name
     * @param string newLastName New last name to set
     * @throws UnexpectedValueException If newLastName contain html or php code
     */
    private function setLastName(string $newLastName)
    {
    	if ($newLastName == strip_tags($newLastName))
    		$this->lastName = $newLastName;
    	else
    		throw new UnexpectedValueException('Can\'t set lastname : value contain html/PHP code');
    }

    /**
     * Set pseudo
     * @param string newPseudo New pseudo to set
     * @throws UnexpectedValueException If newPseudo contain html or php code
     */
    private function setPseudo(string $newPseudo)
    {
    	if ($newPseudo == strip_tags($newPseudo))
    		$this->pseudo = $newPseudo;
    	else
    		throw new UnexpectedValueException('Can\'t set pseudo : value contain html/PHP code');
    }

    /**
     * Set mail address
     * @param string newMailAddress New mail address to set
     * @throws UnexpectedValueException If newMailAddress contain html or php code
     * @throws UnexpectedValueException If newMailAddress doesn't match regexp
     */
    private function setMailAddress(string $newMailAddress)
    {
    	if ($newMailAddress != strip_tags($newMailAddress))
    		throw new UnexpectedValueException('Can\'t set mail : value contain html/PHP code');
    	if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $newMailAddress))
    		$this->mailAddress = $newMailAddress;
    	else
    		throw new UnexpectedValueException('Can\'t set mail address to '.$newMailAddress.' because isn\'t respecting format.');
    }

    /**
     * Set password
     * @param string newPassword New password to set
     * @throws UnexpectedValueException If newPassword contain html or php code
     */
    private function setPassword(string $newPassword)
    {
    	if ($newPassword != strip_tags($newPassword))
            throw new UnexpectedValueException('Can\'t set password : value contain html/PHP code');
        else
            $this->password = $newPassword;
    }

    /**
     * Set activation state
     * @param string activation New activation state to set
     */
    private function setIsActive(bool $activation)
    {
    	$this->isActive = $activation;
    }

    /**
     * Set user type
     * @param string newType New type to set : 1->user; 2->admin
     * @throws UnexpectedValueException If newType doesn't correspond to accepted values
     */
    private function setType(int $newType)
    {
    	if ($newType == 1 || $newType == 2)
            $this->type = $newType;
        else    		
  			throw new UnexpectedValueException('Can\'t set type : unauthorized value : '.$newType);
    }
}