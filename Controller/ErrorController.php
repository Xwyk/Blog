<?php

namespace Blog\Controller;

use Blog\Framework\Controller;

/**
 * Manages home display on website
 */
class ErrorController extends Controller
{
    public const VIEW_ERROR     =    "error";
    /**
     * Gets posts list, and displays home view
     */
    public function display(\Exception $error)
    {
        //Dipslay Home view
        $this->render($this::VIEW_ERROR, ['error' => $error]);
    }
}
