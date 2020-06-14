<?php

namespace Blog\Framework;

/**
 * 
 */
class Session

{
	static public function start()
	{	
		session_start();
	}

	static public function stop()
	{	
		session_destroy();
	}

	static public function exists()
	{	
		return isset($_SESSION);
	}

	static public function addAttribute(string $name, string $value)
	{
		if(!self::exists()){
			throw new \Exception("Aucune session n'est lancée");
		}
		$_SESSION[htmlspecialchars($name)] = htmlspecialchars($value);
	}

	static public function existAttribute(string $name)
	{
		if(!self::exists()){
			throw new \Exception("Aucune session n'est lancée");
		}
		return isset($_SESSION[htmlspecialchars($name)]);
	}

	static public function getAttribute(string $name)
	{
		if(!self::exists()){
			throw new \Exception("Aucune session n'est lancée");
		}
		return $_SESSION[htmlspecialchars($name)];
	}
}