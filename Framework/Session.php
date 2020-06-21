<?php

namespace Blog\Framework;

/**
 * 
 */
class Session
{
	public function __construct()
	{	
		if(!isset($_SESSION)){
			session_start();
		}
	}

	public function stop()
	{	
		session_destroy();
	}

	public function addAttribute(string $name, string $value)
	{
		$_SESSION[$name] = $value;
	}

	public function existAttribute(string $name)
	{
		return isset($_SESSION[$name]);
	}

	public function getAttribute(string $name)
	{
		return $_SESSION[$name];
	}
}