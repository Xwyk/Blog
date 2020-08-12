<?php

namespace Blog\Framework;

/**
 *
 */
abstract class Manager
{
    private   $database;
    protected $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
        $this->database = $this->getDatabase();
    }

    private function getDatabase(): \PDO
    {
        if ($this->database === null) {
            $host     = $this->config->getDbHost();
            $port     = $this->config->getDbPort();
            $dbname   = $this->config->getDbName();
            $username = $this->config->getDbUsername();
            $password = $this->config->getDbPassword();
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
    protected function executeRequest(string $request, array $parameters = null)
    {
        $req = $this->database->prepare($request);
        $req->execute($parameters);
        return $req;
    }
}
