<?php

namespace Blog\Framework;

use Blog\Exceptions\FileNotValidException;
use Blog\Exceptions\FileNotFoundException;
use Blog\Exceptions\ValueNotExistsException;

/**
 * Create object from .ini file
 */
class Configuration
{
    //Config array
    protected $config;

    /**
     * Constructor. Read ini file and parse it into an array 
     * @param string $path Path to the ini file
     * @throws FileNotFoundException If ini file doesn't exists or isn't accessible
     * @throws FileNotValidException If ini file isn't valid
     */
    public function __construct(string $path)
    {
        //Check ini file, throw exception if not accessible
        if (!file_exists($path)) {
            throw new FileNotFoundException($path);
        }
        //Parse ini file into array
        $iniArray = parse_ini_file($path, true);
        //Throw exception if file isn't valid
        if (!$iniArray) {
            throw new FileNotValidException($path);
        }
        $this->config = $iniArray;
    }

    /**
     * Return database host value in .ini
     * @return string ['database']['host']
     */
    public function getDbHost(): string
    {
        if (! isset($this->config['database']['host'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['database']['host'];
    }

    /**
     * Return database port value in .ini
     * @return int ['database']['port']
     */
    public function getDbPort(): int
    {
        if (! isset($this->config['database']['port'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['database']['port'];
    }

    /**
     * Return database name value in .ini
     * @return string ['database']['dbname']
     */
    public function getDbName(): string
    {
        if (! isset($this->config['database']['dbname'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['database']['dbname'];
    }

    /**
     * Return database username value in .ini
     * @return string ['database']['username']
     */
    public function getDbUsername(): string
    {
        if (! isset($this->config['database']['username'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['database']['username'];
    }

    /**
     * Return database password value in .ini
     * @return string ['database']['password']
     */
    public function getDbPassword(): string
    {
        if (! isset($this->config['database']['password'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['database']['password'];
    }

    public function getThemeDirectory(){
        if (! isset($this->config['templates']['directory'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['templates']['directory'];
        
    }

    public function getRoutes()
    {
    	if (! isset($this->config['routes'])) {
            throw new ValueNotExistsException();
        }
        return $this->config['routes'];
    }

}
