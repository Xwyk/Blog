<?php

namespace Blog\Framework;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Create view for end-user
 */
class View
{
    protected const TEMPLATING_TWIG_EXTENSION = '.twig';
    protected $templatingEngine;
    protected $router;
    // protected $routesNames;
    /**
     * Constructor. Instanciate templating engine
     */
    public function __construct(Configuration $config, Router $router)
    {
        $this->router           = $router;
        $loader                 = new FilesystemLoader($config->getThemeDirectory());
        $this->templatingEngine = new Environment($loader, [
            'debug' => true
        ]);
        // $this->routesNames = $config->getRoutes();
    }

    /**
     * Create a view for end user by calling file passed in parameters
     * @param  string     $view       PHP view to call
     * @param  array|null $parameters Parameters to pass to view
     */
    public function render(string $view, array $parameters = null)
    {
        $parameters['router'] = $this->router;
        //Print on screen twig template
        $this->templatingEngine->display($view.$this::TEMPLATING_TWIG_EXTENSION, $parameters);
    }
}
