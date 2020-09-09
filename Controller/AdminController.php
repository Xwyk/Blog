<?php

namespace Blog\Controller;

use Blog\Framework\SecuredController;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Manager\PostManager;
use Blog\Exceptions\NotEnoughRightsException;

/**
 * Manages admin display on website
 */
class AdminController extends SecuredController
{
    public const URL_ADMIN      =    "/?action=admin";

    public const URL_HOME       =    "/?action=home";

    public const VIEW_ADMIN = "admin";
    /**
     * Displays admin view if user is connected and admin
     * Redirects to login if user isn't connected
     * Throw exception if user is connected and isn't admin
     * @throws Blog\Exceptions\NotEnoughRightsException if user is connected and isn't admin 
     */
    public function display()
    {
        $this->checkAdminRights();
        //Render admin view with all comments and create new token for actions
        $this->render($this::VIEW_ADMIN, [
            'comments' => $this->getAllComments(),
            'token'    => $this->getToken(),
            'posts'    => $this->getAllPosts()
        ]);
    }

    /**
     * Call CommentManager for getting all invalids comments
     * @return array Returns an array, empty or filled with all invalids comments
     */
    protected function getAllInvalidComments()
    {
        $this->checkAdminRights();
        return (new CommentManager($this->config))->getAllInvalid();
    }
    /**
     * Call CommentManager for getting all comments
     * @return array Returns an array, empty or filled with all comments
     */
    protected function getAllComments()
    {
        $this->checkAdminRights();
        return (new CommentManager($this->config))->getAll();
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

    protected function getAllPosts()
    {
        return (new PostManager($this->config))->getAll();
    }
}
