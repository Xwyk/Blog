<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\CommentManager;
use Blog\Exceptions\NotEnoughRightsException;

/**
 * Manages admin display on website
 */
class AdminController extends Controller
{
    /**
     * Displays admin view if user is connected and admin
     * Redirects to login if user isn't connected
     * Throw exception if user is connected and isn't admin
     * @throws Blog\Exceptions\NotEnoughRightsException if user is connected and isn't admin 
     */
    public function display()
    {
        //If user isn't admin, redirect to login if not connected, generate exception if no rights
        if (!$this->isAdmin()) {
            if (!$this->isUser()) {
                $this->redirect($this::URL_LOGIN);
            }
            throw new NotEnoughRightsException();
        }
        //Render admin view with all comments and create new token for actions
        $this->render($this::VIEW_ADMIN, [
            'comments' => $this->getAllComments(),
            'token'    => $this->getToken()
        ]);
    }

    /**
     * Call CommentManager for getting all invalids comments
     * @return array Returns an array, empty or filled with all invalids comments
     */
    protected function getAllInvalidComments()
    {
        return (new CommentManager($this->config))->getAllInvalidComments();
    }
    /**
     * Call CommentManager for getting all comments
     * @return array Returns an array, empty or filled with all comments
     */
    protected function getAllComments()
    {
        return (new CommentManager($this->config))->getAllComments();
    }
    /**
     * [getAllComments description]
     * @return [type] [description]
     */
    protected function getAllUsers()
    {
        //return (new CommentManager($this->config))->getAllInvalidComments();
    }
    /**
     * [getAllComments description]
     * @return [type] [description]
     */
    protected function getAdminUsers()
    {
        //return (new CommentManager($this->config))->getAllInvalidComments();
    }
    /**
     * [getAllComments description]
     * @return [type] [description]
     */
    protected function getNonAdminUsers()
    {
        //return (new CommentManager($this->config))->getAllInvalidComments();
    }
}
