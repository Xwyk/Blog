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
    protected $config;

    public function __construct(array $get, Configuration $config, array $post = [], array $file = [])
    {
        $this->getArray = new EnvironmentArray($get);
        $this->config = $config;
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

    public function getFilesValue(string $key)
    {
        return $this->fileArray->get($key);
    }

    public function getUrl()
    {
        return $this->config->getWebsiteRoot()."/".$this->getArray->get('url');
    }
}