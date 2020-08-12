<?php

namespace Blog\Framework;

/**
 *
 */
abstract class Controller
{
    //Constants for URLs
    public const URL_ADMIN      =    "/?action=admin";
    public const URL_HOME       =    "/?action=home";
    public const URL_LOGIN      =    "/?action=login";
    public const URL_LOGOUT     =    "/?action=logout";
    public const URL_REGISTER   =    "/?action=register";
    public const URL_POST       =    "/?action=post&id=";
    public const URL_ADDPOST    =    "/?action=addPost";
    public const URL_ADDCOMMENT =    "/?action=addComment&postId=";
    public const URL_EDITPOST   =    "/?action=editPost&id=";
    
    //Constants for views (filenames)
    public const VIEW_ADDPOST   =    "addPost";
    public const VIEW_ADMIN     =    "admin";
    public const VIEW_EDITPOST  =    "editPost";
    public const VIEW_HOME      =    "home";
    public const VIEW_LOGIN     =    "login";
    public const VIEW_POST      =    "post";
    public const VIEW_REGISTER  =    "register";

    //Templating engine
    public $templating;
    //Session object
    public $session;
    //Configuration object
    public $config;
    //String which contains redirection to another page after treatment
    protected $redirection;

    /**
     * Constructor. Set values.
     * @param View          $view    Templating engine
     * @param Session       $session Session object
     * @param Configuration $config  Configuraiton object
     */
    public function __construct(View $view, Session $session, Configuration $config)
    {
        $this->templating = $view;
        $this->session    = $session;
        $this->config     = $config;
    }

    /**
     * Render page through templating engine
     * @param  string $path   Path to php file 
     * @param  array  $params Array of parameters to send to templating engine
     */
    protected function render(string $path, array $params = [])
    {
        //Adding session object to parameters for view access and call templating render
        $params += ['session'=> $this->session];
        $this->templating::render($path, $params);
    }

    /**
     * Set redirection URL to redirect after treatment
     * @param string $redirection URL to redirect to
     */
    protected function setRedirection(string $redirection)
    {
        $this->redirection=urlencode($redirection);
    }

    /**
     * Return redirection activation status
     * @return boolean true => redirection active; false => redirection inactive
     */
    public function isRedirectionConfigured(): bool
    {
        return isset($this->redirection);
    }

    /**
     * Rectirect to URL. If redirection is configured in this, redirect to $this->redirection.
     * @param  string $path url to redirect
     */
    protected function redirect(string $path)
    {
        //If there is an activated redirection, redirect it, else, redirect to pssed value
        if ($this->isRedirectionConfigured()) {
            header("Location: ".urldecode($this->redirection));
            return;
        }
        header("Location: ".$path);
    }

    /**
     * Admin status
     * @return boolean true => connected user is admin; false => connected user isn't admin
     */
    public function isAdmin(): bool
    {
        return $this->session->isAdmin();
    }

    /**
     * User status
     * @return boolean true => connected user is user; false => user isn't connected
     */
    public function isUser(): bool
    {
        return $this->session->isAuthenticated();
    }

    /**
     * Get a new token
     * @return string Token to use
     */
    public function getToken(): string
    {
        return $this->session->getToken($this->config);
    }

    /**
     * Checks token validity
     * @param  string $tokenToCheck Token value to check
     * @return int                  Check status
     */
    public function checkToken(string $tokenToCheck): int
    {
        return $this->session->checkToken($tokenToCheck, $this->config);
    }
    
    //abstract public function display();
}
