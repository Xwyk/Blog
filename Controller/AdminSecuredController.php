<?php

namespace Blog\Controller;

use Blog\Framework\SecuredController;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Manager\PostManager;
use Blog\Exceptions\NotEnoughRightsException;

/**
 * Manages admin display on website
 */
class AdminSecuredController extends SecuredController
{
	// Template name whithout extension
    public const VIEW_ADMIN = "admin";
    
    /**
     * Displays admin view 
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
     * Call CommentManager for getting all comments
     * @return array Returns an array, empty or filled with all comments
     */
    protected function getAllComments()
    {
        $this->checkAdminRights();
        return (new CommentManager($this->config))->getAll();
    }

    /**
     * Call PostManager for getting all posts
     * @return array Returns an array, empty or filled with all posts
     */
    protected function getAllPosts()
    {
        return (new PostManager($this->config))->getAll();
    }
}
