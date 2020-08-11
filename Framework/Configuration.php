<?php

namespace Blog\Framework;

use Blog\Exceptions\NotValidFileException;
use Blog\Exceptions\FileNotFoundException;

/**
 *
 */
class Configuration
{
    protected $config;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }
        $iniArray = parse_ini_file($path, true);
        if (!$iniArray) {
            throw new NotValidFileException($path);
        }
        $this->config = $iniArray;
    }

    public function getHost()
    {
        return $this->config['database']['host'];
    }
    public function getPort()
    {
        return $this->config['database']['port'];
    }
    public function getDbName()
    {
        return $this->config['database']['dbname'];
    }
    public function getUsername()
    {
        return $this->config['database']['username'];
    }
    public function getPassword()
    {
        return $this->config['database']['password'];
    }
}
