<?php

namespace Blog\Framework;

/**
 * 
 */
class Redirection
{
	protected $name;
	protected $params;

	public function __construct(string $name, array $params = [])
	{
		$this->name   = $name;
		$this->params = $params;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getParams()
	{
		return $this->params;
	}
}