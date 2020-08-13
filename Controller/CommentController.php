<?php

namespace Blog\Controller;

use Blog\Framework\SecuredController;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Manager\TokenManager;
use Blog\Model\Comment;
use Blog\Exceptions\ExpiredTokenException;
use Blog\Exceptions\NotEnoughRightsException;
use Blog\Exceptions\NotConnectedUserException;

/**
 * Manages actions on comments :
 *     - add        : user rights
 *     - validate   : admin rights
 *     - invalidate : admin rights
 *     - remove     : admin rights
 */
class CommentController extends SecuredController
{
    /**
     * Add a comment for a post. Gets post id in 'postId' value in url (GET) and datas by form (POST)
     * @throws PostNotFoundException If id isn't valid : <= 0
     */
    public function addComment()
    {
        $this->checkUserRights();
        //Get and check post id via GET
        $postId = filter_input(INPUT_GET, 'postId', FILTER_VALIDATE_INT);
        if ($postId == false) {
            throw new PostNotFoundException($postId);
        }
        //Create comment object with POST value, session user, an post id
        $comment = new Comment([
            'content' => filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'author'  => $this->session->getAttribute('user'),
            'postId'  => $postId
        ]);
        //Add newly created object in database
        (new CommentManager($this->config))->add($comment);
        //Redirect to post page
        $this->redirect($this::URL_POST.$postId);
    }

    /**
     * Validate a comment in database
     * @todo redirection
     */
    public function validateComment()
    {
        //Validate comment
        $this->updateCommentValidation(true);
        //Redirect
        // $this->redirect($this::URL_POST.(new CommentManager($this->config))->getCommentById($id)->getPostId());
    }

    /**
     * Invalidate a comment in database
     * @todo redirection
     */
    public function invalidateComment()
    {
        //Invalidate comment
        $this->updateCommentValidation(false);
        //Redirect
        // $this->redirect($this::URL_POST.(new CommentManager($this->config))->getCommentById($id)->getPostId());
    }

    /**
     * Change validation state of a comment. Gets comment id value by url (GET) and token by form (POST)
     * Checks token by comparing POST token and session token
     * @param  bool   $valid validation status : true => valid, false => invalid
     * @todo add exceptions classes
     * @throws ExpiredTokenException If token is valid but expired
     * @throws NotValidTokenException If token isn't valid
     * @throws NotValidCommentIdException If comment id isn't valid
     */
    protected function updateCommentValidation(bool $valid)
    {
        $this->checkAdminRights();
        //Get values from GET and POST, checks token  
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $resultCheck = $this->session->checkToken($token);
        //If id is'nt valid, throw exception
        if (!$id) {
            throw new \Exception("Commentaire non valide");
        }
        //Switch check result for throwing associated exception
        switch ($resultCheck) {
            case TokenManager::TOKEN_VALID:
                break;
            case TokenManager::TOKEN_EXPIRED:
                throw new ExpiredTokenException();
                break;
            case TokenManager::TOKEN_INVALID:
                throw new \Exception("Token non valide");
                break;
        }
        //Change comment validation in database
        if ($valid) {
            (new CommentManager($this->config))->validateComment($id);
            return;
        }
        (new CommentManager($this->config))->invalidateComment($id);
    }

    /**
     * Remove a comment in database. Gets comment id value by url (GET)
     */
    public function removeComment()
    {
        $this->checkAdminRights();
        //Gets comment id
        $commentId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        //Create comment object
        $comment = (new CommentManager($this->config))->getCommentById($commentId);
        //remove object from database
        (new CommentManager($this->config))->remove($comment);
    }
}
