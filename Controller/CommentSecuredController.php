<?php

namespace Blog\Controller;

use Blog\Framework\SecuredController;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Manager\TokenManager;
use Blog\Model\Comment;
use Blog\Exceptions\ExpiredTokenException;
use Blog\Exceptions\InvalidTokenException;

/**
 * Manages admin actions on comments :
 */
class CommentSecuredController extends SecuredController
{
    /**
     * Add a comment for a post. Gets post id in 'postId' value in url (GET) and datas by form (POST)
     * @throws PostNotFoundException If id isn't valid : <= 0
     */
    public function add(int $postId)
    {
        $error = null;
        try{
            $this->checkUserRights();
            //Get and check post id via GET
            if ($postId < 0) {
                throw new PostNotFoundException($postId);
            }
            //Create comment object with POST value, session user, an post id
            $comment = new Comment([
                'content' => $this->router->request->getPostValue('commentText'),
                'author'  => $this->session->getAttribute('user'),
                'postId'  => $postId
            ]);
            //Add newly created object in database
            $response = (array('rowAffecteds' => (new CommentManager($this->config))->add($comment)->rowCount()));
        } catch (\Exception $e){
            $error = $e;
        }
        $this->render('request', [
            'response' => $this->formatResponseArray($response, $error)
        ]);
    }

    /**
     * Validate a comment in database
     */
    public function validate(int $id)
    {
        $error = null;
        //Validate comment
        try{
            $response['rowAffecteds'] =  $this->updateValidation($id, true);
        } catch (\Exception $e){
            $error = $e;
        }
        $this->render('request', [
            'response' => $this->FormatResponseArray($response, $error)
        ]);
    }

    /**
     * Invalidate a comment in database
     */
    public function invalidate(int $id)
    {
        $error = null;
        //Invalidate comment
        try{
            $response['rowAffecteds'] =  $this->updateValidation($id, false);
        } catch (\Exception $e){
            $error = $e;
        }
        $this->render('request', [
            'response' => $this->formatResponseArray($response, $error)
        ]);
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
    protected function updateValidation(int $id, bool $valid)
    {
        $this->checkAdminRights();
        //Get values from POST, checks token  
        $token       = $this->router->request->getPostValue('token');
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
                throw new InvalidTokenException();
                break;
        }
        //Change comment validation in database
        if ($valid) {
            return (new CommentManager($this->config))->validate($id)->rowCount();
        }
        return (new CommentManager($this->config))->invalidate($id)->rowCount();
    }

    /**
     * Remove a comment in database. Gets comment id value by url (GET)
     */
    public function remove(int $commentId)
    {
        // set error default value
        $error = null;
        try{
            $this->checkAdminRights();
            // Create comment object
            $comment = (new CommentManager($this->config))->getById($commentId);
            // remove object from database
            $response['rowAffecteds'] = (new CommentManager($this->config))->remove($comment)->rowCount();
        } catch (\Exception $e){
            $error = $e;
        }
        // Render view
        $this->render('request', [
            'response' => $this->formatResponseArray($response, $error)
        ]);
    }

    /**
     * Format a response array to a request
     * @return array Passed array, formatted with error arguments, if they are.
     */
    protected function formatResponseArray(array $responseArray=[], $error)
    {
        $responseArray['message'] = $error? $error->getMessage():'OK';
        $responseArray['code']    = $error? $error->getCode() : '0';
        return $responseArray;
    }
}
