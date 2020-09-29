<?php

namespace Blog\Framework;

use Blog\Framework\Request\EnvironmentArray;
use Blog\Framework\Request\Redirection;

/**
 * 
 */
class Request
{
	const REDIRECTION_KEY = "redirect";
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
		return $this->getArray->get($url);
	}

	public function isRedirectionConfigured()
	{
		return $this->getArray->get($this::REDIRECTION_KEY) !== null;
	}

	public function getRawRedirection()
	{
		if ($this->isRedirectionConfigured()) {
			return $this->getArray->get($this::REDIRECTION_KEY);
		}
	}

	public function getDecodedRedirection()
	{
		if ($this->isRedirectionConfigured()) {
			return urldecode($this->getArray->get($this::REDIRECTION_KEY));
		}
	}
}