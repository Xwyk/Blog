<?php

namespace Blog\Framework;

/**
 *
 */
abstract class Controller
{
    public const URL_ADMIN      =    "/?action=admin";
    public const URL_HOME       =    "/?action=home";
    public const URL_LOGIN      =    "/?action=login";
    public const URL_LOGOUT     =    "/?action=logout";
    public const URL_REGISTER   =    "/?action=register";
    public const URL_POST       =    "/?action=post&id=";
    public const URL_ADDPOST    =    "/?action=addPost";
    public const URL_ADDCOMMENT =    "/?action=addComment&postId=";
    
    public const VIEW_ADDPOST   =    "addPost";
    public const VIEW_ADMIN     =    "admin";
    public const VIEW_EDITPOST  =    "editPost";
    public const VIEW_HOME      =    "home";
    public const VIEW_LOGIN     =    "login";
    public const VIEW_POST      =    "post";
    public const VIEW_REGISTER  =    "register";

    public $templating;
    public $session;
    public $config;

    public function __construct(View $view, Session $session, Configuration $config)
    {
        $this->templating = $view;
        $this->session    = $session;
        $this->config     = $config;
    }

    protected function render(string $path, array $params = [])
    {
        $params += ['session'=> $this->session];
        $this->templating::render($path, $params);
    }

    protected function redirect($path)
    {
        header("Location: ".$path);
    }

    public function isAdmin()
    {
        return $this->session->isAdmin();
    }

    public function isUser()
    {
        return $this->session->isAuthenticated();
    }

    public function getToken()
    {
        return $this->session->getToken($this->config);
    }

    public function checkToken(string $tokenToCheck)
    {
        return $this->session->checkToken($tokenToCheck, $this->config);
    }
    
    //abstract public function display();
}
