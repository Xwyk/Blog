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

	public function __construct(array $get, array $post = [])
	{
		$this->getArray    = new EnvironmentArray($get);
		if (!empty($post)) {
			$this->postArray = new EnvironmentArray($post);
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

	public function getUrl()
	{
		return $this->getArray->get('url');
	}
}