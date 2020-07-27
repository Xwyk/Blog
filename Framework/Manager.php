<?php
namespace Blog\Framework;
/**
 * 
 */
abstract class Manager
{
	static private $database;
	
	static private function getDatabase(string $configPath) : \PDO
	{
		$config = new Configuration($configPath);
		$host = $config->config['database']['host'];
		$port = $config->config['database']['port'];
		$dbname = $config->config['database']['dbname'];
		$username = $config->config['database']['username'];
		$password = $config->config['database']['password'];
		// If database isn't set, set it and return it		
		if (self::$database === null){
            self::$database = new \PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname.';charset=utf8', $username, $password);  
		}
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
		$req = self::getDatabase(__DIR__.'/../config/config.php')->prepare($request);
		$req->execute($parameters);
		return $req; 
	}
}