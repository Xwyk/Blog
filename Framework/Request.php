<?php

namespace Blog\Framework;

use Blog\Framework\Request\EnvironmentArray;
use Blog\Framework\Request\Redirection;

/**
 * 
 */
class Request
{
	protected $url;
	protected $get;
	protected $post;
	protected $redirection;

	public function __construct(array $get, array $post = [])
	{
		$this->url         = $get['url'];
		$this->get         = new EnvironmentArray($get);
		if (!empty($post)) {
			$this->post        = new EnvironmentArray($post);
		}
	}

	public function getGetValue(string $key)
	{
		return $this->get->get($key);
	}

	public function getPostValue(string $key)
	{
		return $this->get->post($key);
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function isRedirectionConfigured()
	{
		return isset($this->redirection);
	}

	protected function setRedirection(string $name, array $params = [])
	{
		$this->redirection = new Redirection($name, $params);
	}


}