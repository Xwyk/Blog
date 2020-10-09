<?php

namespace Blog\Framework;

use Blog\Framework\EnvironmentArray;

/**
 * 
 */
class Request
{
	protected $getArray;
	protected $postArray;
	protected $fileArray;

	public function __construct(array $get, array $post = [], array $file = [])
	{
		$this->getArray    = new EnvironmentArray($get);
		if (!empty($post)) {
			$this->postArray = new EnvironmentArray($post);
		}
		if (!empty($file)) {
			$this->fileArray = new EnvironmentArray($file);
		}
	}

	public function getGetValue(string $key)
	{
		return $this->getArray->get($key);
	}

	public function getPostValue(string $key)
	{
		return $this->postArray->get($key);
	}

	public function getFileValue(string $key)
	{
		return $this->fileArray->get($key);
	}

	public function getUrl()
	{
		return $this->getArray->get('url');
	}
}