<?php

namespace Blog\Controller;

use Blog\Model\Manager\PostManager;
use Blog\Framework\Controller;

/**
 * Manages home display on website
 */
class HomeController extends Controller
{
    public const VIEW_HOME = "home";
    /**
     * Gets posts list, and displays home view
     */
    public function display()
    {
        //Get posts list
        $articles = (new PostManager($this->config))->getAll();
        return $this->render($this::VIEW_HOME, ['articles' => $articles]);
    }
}