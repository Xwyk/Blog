<?php

namespace Blog\Framework;

use Blog\Exceptions\ViewNotFoundException;
use Twig\Error\LoaderError;

/**
 *
 */
abstract class Controller
{
    //Templating engine
    public $templating;
    //Session object
    public $session;
    //Configuration object
    public $config;

    public $router;
    //String which contains redirection to another page after treatment
    protected $redirection;
    //
    protected $routes;

    /**
     * Constructor. Set values.
     * @param View          $view    Templating engine
     * @param Session       $session Session object
     * @param Configuration $config  Configuraiton object
     */
    public function __construct(View $view, Session $session, Configuration $config, Router $router)
    {
        $this->templating = $view;
        $this->session    = $session;
        $this->config     = $config;
        $this->routes     = $config->getRoutes();
        $this->router     = $router;
    }

    /**
     * Render page through templating engine
     * @param  string $view   Name of the view 
     * @param  array  $params Array of parameters to send to templating engine
     */
    protected function render(string $view, array $params = [])
    {
        //Adding session object to parameters for view access and call templating render
        $params += [
            'session'=> $this->session,
            'themeDirectory' => $this->config->getThemeDirectory()    
        ];
        //If file can't be found, throw exception
        try{
            $this->templating->render($view, $params);
        } catch (LoaderError $e) {
            throw new ViewNotFoundException($view);
        }
    }

    /**
     * Set redirection URL to redirect after treatment
     * @param string $redirection URL to redirect to
     */
    protected function setRedirection(string $redirection)
    {
        $this->redirection = urlencode($redirection);
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
        // If there is an activated redirection, redirect it, else, redirect to pssed value
        if ($this->isRedirectionConfigured()) {
            header("Location: ".urldecode($this->redirection));
            return;
        }
        header("Location: /".$path);
    }
}
