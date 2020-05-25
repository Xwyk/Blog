<?php
namespace Blog\Framework;
/**
 * 
 */
abstract class Manager
{
	static private $database;
	
	static private function getDatabase() : \PDO
	{
		// If database isn't set, set it and return it		
		if (self::$database === null)
            self::$database = new \PDO('mysql:host=localhost;port=3308;dbname=blog;charset=utf8', 'root', '');  
        return self::$database;
	}

	/**
	 * Execute a request and return PDOStatement
	 * @param string request : sql request to execute
	 * @param array  Parameters : parameters to set for the request
	 * @return PDOStatement : result of the query 
	 */
	static protected function executeRequest(string $request, array $parameters = null)
	{
		$req = self::getDatabase()->prepare($request);
		$req->execute($parameters);
		return $req; 
	}
}