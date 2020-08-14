<?php

namespace Blog\Framework;

use Blog\Exceptions\FileNotFoundException;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Create view for end-user
 */
class View
{
    protected const TEMPLATING_TWIG_DIRECTORY = './templates';
    protected const TEMPLATING_TWIG_EXTENSION = './twig';
    protected $templatingEngine;

    /**
     * Constructor. Instanciate templating engine
     */
    public function __construct()
    {
        $loader = new FilesystemLoader($this->TEMPLATING_TWIG_DIRECTORY);
        $this->templatingEngine = new Environment($loader);
    }

    /**
     * Create a view for end user by calling file passed in parameters
     * @param  string     $view       PHP view to call
     * @param  array|null $parameters Parameters to pass to view
     */
    public function render(string $view, array $parameters = null)
    {
        //Print on screen twig template
        echo $this->templatingEngine->render($view.$this->TEMPLATING_TWIG_EXTENSION, $parameters);
    }
}
