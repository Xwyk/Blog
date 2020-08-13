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
    public function __construct()
    {
        # code...
    }

    /**
     * Create a view for end user by calling file passed in parameters
     * @param  string     $view       PHP view to call
     * @param  array|null $parameters Parameters to pass to view
     */
    public static function render(string $view, array $parameters = null)
    {

        $loader = new FilesystemLoader('./View/content');
        $twig = new Environment($loader);
        //Create variables from passed array
        // if (isset($parameters)) {
        //     extract($parameters);
        // }
        // //If view exists, call it and store content
        // $contentFile = __DIR__.'/../View/content/'.$view.'.php';
        // if (!file_exists($contentFile)) {
        //     throw new FileNotFoundException($view);
        // }
        // ob_start();
        // require $contentFile;
        // $content=ob_get_clean();

        // $parameters['content'] = $content;
        //Call primary template
        // require self::VIEW_TEMPLATE;
        echo $twig->render($view.'.twig', $parameters);
    }
}
