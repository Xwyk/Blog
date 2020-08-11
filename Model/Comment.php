<?php

namespace Blog\Model;

use Blog\Framework\Entity;
/**
 * public class who define an user. Extends TextContent
 *
 * @author     Florian LEBOUL
 */
class Comment extends Entity
{
    private $id;
    private $creationDate;
    private $validationDate;
    private $content;
    private $author;
    private $isValid;
    private $validatorId;
    private $postId;

    /**
     * Construct object
     * @param array data Associative array containing values for variables
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Return valid state
     * @return bool isValid
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * Return validator id
     * @return int validatorId
     */
    public function getValidatorId()
    {
        return $this->validatorId;
    }

    /**
     * Return post id
     * @return int postId
     */
    public function getPostId()
    {
        return $this->postId;
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
    public function getValidationDate(){
        return $this->validationDate;
    }

    /**
     * Return content
     * @return string content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return author
     * @return User author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    protected function setIsValid($newIsValid)
    {
        $this->isValid = $newIsValid;
    }

    /**
     * Set content
     * @param string newContent New content to set
     * @throws UnexpectedValueException If newContent contain html or php code
     */
    protected function setContent(string $newContent)
    {
        if ($newContent != strip_tags($newContent)){
            throw new UnexpectedValueException('Can\'t set content : value contain html/PHP code');
        }
            
        $this->content = $newContent;
            
    }

    /**
     * Set author
     * @param user newAuthor New author to set. This can be set once
     * @throws RangeException If newAuthor isn't bigger than 0
     * @throws Exception If newAuthor is already set
     * @throws InvalidArgumentException If newAuthor isn't a number
     */
    protected function setAuthor(User $newAuthor)
    {
        // If id is already set, throw exception
        if (isset($this->author)){
            throw new Exception('Can\'t change author of an object once it was set');
        }
        $this->author = $newAuthor;
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
        $this->id = $newID;
    }

    /**
     * Set creationDate value
     * @param Date newDate New date to set
     */
    protected function setCreationDate(string $newDate){
        if ($newDate===null)
            $this->creationDate = "";
        else
            $this->creationDate = (new \DateTime())->createFromFormat('Y-m-d H:i:s', $newDate);
        
    }

    /**
     * Set creationDate value
     * @param Date newDate New date to set
     */
    protected function setValidationDate(string $newDate){
        if ($newDate===null)
            $this->validationDate = "";
        
        else
            $this->validationDate = (new \DateTime())->createFromFormat('Y-m-d H:i:s', $newDate);
        
    }

    /**
     * Set validator id
     * @param string newValidatorId New author to set. This can be set once
     * @throws RangeException If newValidatorId isn't bigger than 0
     * @throws Exception If newValidatorId is already set
     * @throws InvalidArgumentException If newValidatorId isn't a number
     */
    protected function setValidatorId(int $newValidatorId)
    {
        // If id is already set, throw exception
        if (isset($this->validatorId))
            throw new Exception('Can\'t change validator of an object once it was set');
        if ($newValidatorId <= 0)
            throw new RangeException('La valeur de l\'identifiant ne pet pas être inférieure ou égale à 0');
        $this->validatorId = $newValidatorId;
    }

    /**
     * Set post id
     * @param string newPostId New post id to set. This can be set once
     * @throws RangeException If newPostId isn't bigger than 0
     * @throws Exception If newPostId is already set
     * @throws InvalidArgumentException If newPostId isn't a number
     */
    protected function setPostId(int $newPostId)
    {
        // If id is already set, throw exception
        if (isset($this->postId))
            throw new Exception('Can\'t change post id of an object once it was set');
        // If id is numeric and bigger than 0, attribute value, else throw exception
        if (is_numeric($newPostId))
            if ($newPostId > 0)
                $this->postId = $newPostId;
            else
                throw new RangeException('La valeur de l\'identifiant ne pet pas être inférieure ou égale à 0');
        else
            throw new InvalidArgumentException('Le type de l\'argument fourni ne correspond pas à un nombre ');
    }
}
