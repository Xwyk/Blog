<?php
namespace Blog\Model;
/**
 * 
 */
class Post
{
	private $id;
	private $creationDate;
	private $content;
	private $author;
	private $modificationDate;
	private $chapo;
    private $title;
	private $comments;


	public function __construct(array $data)
	{
        $comments=[];
		$this->hydrate($data);
	}

	public function hydrate(array $data)
	{
		// For each key in array, searching associated setter (ie : key 'id', setter 'setId') 
		// if method exist, call her with value as parameter
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
        }
        else{
    		$this->creationDate = \DateTime::createFromFormat('Y-m-d H:i:s', $newDate);
        }
    	
    }

    /**
     * Set modificationDate value
     * @param Date newDate New date to set
     */
    protected function setModificationDate(string $newDate){
    	if (is_null($newDate)){
            $this->creationDate="";
        }
        else{
    		$this->modificationDate = \DateTime::createFromFormat('Y-m-d H:i:s', $newDate);
        }
    	
    }

	/**
     * Set chapo
     * @param string newChapo New chapo to set
     * @throws UnexpectedValueException If newChapo contain html or php code
     */
	public function setChapo(string $newChapo)
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
	public function setTitle(string $newTitle)
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
    public function setComments(array $newComments)
    {
        $this->comments = $newComments;
    }
}
