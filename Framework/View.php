<?php

namespace Blog\Framework;

use Blog\Exceptions\FileNotFoundException;

/**
 *
 */
class View
{
    protected const VIEW_TEMPLATE=__DIR__.'/../View/pages/template.php';
    public static function render(string $view, array $parameters = null)
    {
        if (isset($parameters)) {
            extract($parameters);
        }
        $contentFile = __DIR__.'/../View/content/'.$view.'.php';
        if (!file_exists($contentFile)) {
            throw new FileNotFoundException($view);
        }
        ob_start();
        require $contentFile;
        $content=ob_get_clean();

        require self::VIEW_TEMPLATE;
    }
}
