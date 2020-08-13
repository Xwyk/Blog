<?php

namespace Blog\Framework;

use Blog\Exceptions\FileNotFoundException;

/**
 * Create view for end-user
 */
class View
{
    //Primary template for the view
    protected const VIEW_TEMPLATE=__DIR__.'/../View/pages/template.php';
    
    /**
     * Create a view for end user by calling file passed in parameters
     * @param  string     $view       PHP view to call
     * @param  array|null $parameters Parameters to pass to view
     */
    public static function render(string $view, array $parameters = null)
    {
        //Create variables from passed array
        if (isset($parameters)) {
            extract($parameters);
        }
        //If view exists, call it and store content
        $contentFile = __DIR__.'/../View/content/'.$view.'.php';
        if (!file_exists($contentFile)) {
            throw new FileNotFoundException($view);
        }
        ob_start();
        require $contentFile;
        $content=ob_get_clean();

        //Call primary template
        require self::VIEW_TEMPLATE;
    }
}
