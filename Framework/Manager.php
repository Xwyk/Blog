<?php

namespace Blog\Framework;

/**
 * Represents a database request executor
 */
abstract class Manager
{
    //PDO object
    private   $database;
    //Configuration Object
    protected $config;

    /**
     * Constructor. Set values
     * @param Configuration $config configuration object to access database
     */
    public function __construct(Configuration $config)
    {
        $this->config   = $config;
        $this->database = $this->getDatabase();
    }

    /**
     * Return a database accessible with Configuration object
     * @return PDO Database object
     */
    private function getDatabase(): \PDO
    {
        //If $this->database isn't set, set it
        if ($this->database === null) {
            $host           = $this->config->getDbHost();
            $port           = $this->config->getDbPort();
            $dbname         = $this->config->getDbName();
            $username       = $this->config->getDbUsername();
            $password       = $this->config->getDbPassword();
            $this->database = new \PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname.';charset=utf8', $username, $password);
        }
        return $this->database;
    }

    /**
     * Execute a request and return PDOStatement
     * @param string request : sql request to execute
     * @param array  Parameters : parameters to set for the request
     * @return PDOStatement : result of the query
     */
    /**
     * Execute a request and return PDOStatement
     * @param  string     $request    SQL request to execute
     * @param  array|null $parameters Parameters to set fir request
     * @return PDOStatement|false     Result of the query / false if no results
     */
    protected function executeRequest(string $request, array $parameters = null)
    {
        //Prepare request
        $req = $this->database->prepare($request);
        //Execute request
        $req->execute($parameters);
        return $req;
    }
}
