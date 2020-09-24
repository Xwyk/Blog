<?php

namespace Blog\Framework\Request;

/**
 * 
 */
class EnvironmentArray
{
	protected $array;

	public function __construct(array $array)
	{
		$this->array = $array;
	}

	public function exists(string $key){
		return isset($this->array[$key]);
	}

	public function isEmpty(){
		return empty($this->array);
	}

	public function get(string $key){
		if (!$this->exists($key)) {
			throw new Exception("La clé demandée n'existe pas", 1);
		}
		return $this->array[$key];
	}
}