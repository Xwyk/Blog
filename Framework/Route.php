<?php

namespace Blog\Framework;

/**
 * Represents an entity in database
 */
class Route
{
    protected $path;
    protected $callable;
    protected $matches = [];
    protected $params = [];

    public function __construct(string $path, $callable){
        $this->path = trim($path, '/');  // On retire les / inutils
        $this->callable = $callable;
    }

    /**
    * Permettra de capturer l'url avec les paramètre 
    * get('/posts/:slug-:id') par exemple
    **/
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call($view, $session, $config){
        if(is_string($this->callable)){
            $params = explode('#', $this->callable);
            $controller = "Blog\\Controller\\" . $params[0] . "Controller";
            $controller = new $controller($view, $session, $config);
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function with($param, $regex){
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this; // On retourne tjrs l'objet pour enchainer les arguments
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
    return $path;
}
}