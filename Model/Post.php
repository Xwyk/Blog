<?php
namespace Blog\Model;
use Blog\Framework\Entity;
/**
 * 
 */
class Post extends Entity
{
	private $id;
	private $creationDate;
	private $content;
	private $author;
	private $modificationDate;
	private $chapo;
    private $title;
    private $comments;
	private $picture;


	public function __construct(array $data)
	{
        $this->$comments=[];
		$this->hydrate($data);
	}

	/**
     * Return chapo
     * @return string chapo
     */
	public function getChapo()
	{
		return $this->chapo;
	}

	/**
     * Return title
     * @return string title
     */
	public function getTitle()
	{
		return $this->title;
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

    /**
     * Return comments
     * @return User comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Return picture
     * @return string picture path
     */
    public function getPicture()
    {
        return $this->picture;
    }

	/**
     * Set content
     * @param string newContent New content to set
     * @throws UnexpectedValueException If newContent contain html or php code
     */
	public function setContent(string $newContent)
	{
		if ($newContent != strip_tags($newContent)){
    		throw new UnexpectedValueException('Can\'t set content : value contain html/PHP code');
        }
		$this->content = $newContent;
	}

	/**
     * Set author
     * @param User newAuthor New author to set. This can be set once
     */
	public function setAuthor(User $newAuthor)
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
     */
    protected function setID(int $newID){
        // If id is already set, throw exception
        if (isset($this->id)){
            throw new Exception('Can\'t change id of an object once it was set');
        }
    	if ($newID <= 0){
			throw new RangeException('La valeur de l\'identifiant ne pet pas être inférieure ou égale à 0');
        }
		$this->id = $newID;
    }

    /**
     * Set creationDate value
     * @param Date newDate New date to set
     */
    protected function setCreationDate(string $newDate){
    	if ($newDate === null){
            $this->creationDate="";
            return;
        }
    	$this->creationDate = (new \DateTime())->createFromFormat('Y-m-d H:i:s', $newDate);
    }

    /**
     * Set modificationDate value
     * @param Date newDate New date to set
     */
    protected function setModificationDate(string $newDate){
    	if (is_null($newDate)){
            $this->creationDate="";
            return;
        }
   		$this->modificationDate = (new \DateTime())->createFromFormat('Y-m-d H:i:s', $newDate);
    	
    }

	/**
     * Set chapo
     * @param string newChapo New chapo to set
     * @throws UnexpectedValueException If newChapo contain html or php code
     */
	protected function setChapo(string $newChapo)
	{
		if ($newChapo != strip_tags($newChapo)){
    		throw new UnexpectedValueException('Can\'t set chapo : value contain html/PHP code');
        }
		$this->chapo = $newChapo;
	}

	/**
     * Set title
     * @param string newTitle New title to set
     * @throws UnexpectedValueException If newTitle contain html or php code
     */
	protected function setTitle(string $newTitle)
	{
		if ($newTitle != strip_tags($newTitle)){
    		throw new UnexpectedValueException('Can\'t set title : value contain html/PHP code');
        }
		$this->title = $newTitle;
	}

    /**
     * Set comments
     * @param array newComments New title to set
     */
    protected function setComments(array $newComments)
    {
        $this->comments = $newComments;
    }

    /**
     * Set picture
     * @param string newPicture New image to set
     */
    protected function setPicture(string $newPicture)
    {
        $this->picture = $newPicture;
    }

}
