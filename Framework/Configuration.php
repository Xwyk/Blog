<?php
namespace Blog\Framework;

use Blog\Exceptions\NotValidFileException;
use Blog\Exceptions\FileNotFoundException;

/**
 * 
 */
class Configuration{
	public $config;

	public function __construct(string $path=__DIR__.'/config/config.local.php')
	{
		if (!file_exists($path)) {
			throw new FileNotFoundException($path);
		}
		$ini_array = parse_ini_file($path, true);
		if (!$ini_array) {
			throw new NotValidFileException($path);
		}
		$this->config = $ini_array;
	}
}