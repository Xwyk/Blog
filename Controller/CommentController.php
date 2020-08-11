<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Manager\TokenManager;
use Blog\Model\Comment;
use Blog\Framework\View;
use Blog\Framework\Session;

class CommentController extends Controller
{
    
    public function addComment()
    {

        $postId = filter_input(INPUT_GET, 'postId', FILTER_VALIDATE_INT);
        if ($postId == false) {
            throw new PostNotFoundException($postId);
        }
        $comment = new Comment([
            'content' => filter_input(INPUT_POST, 'commentText', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'author'  => $this->session->getAttribute('user'),
            'postId'  => $postId
        ]);
        (new CommentManager($this->config))->add($comment);
        $this->redirect($this::URL_POST.$postId);
    }

    public function validateComment()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $resultCheck = $this->session->checkToken($token);
        
        switch ($resultCheck) {
            case TokenManager::TOKEN_VALID:
                break;
            case TokenManager::TOKEN_EXPIRED:
                throw new \Exception("Token Expiré");
                break;
            case TokenManager::TOKEN_INVALID:
                throw new \Exception("Token non valide");
                break;
        }
        if ($id == false) {
            throw new \Exception("Commentaire non valide");
        }
        (new CommentManager($this->config))->validateComment($id);
        // $this->redirect($this::URL_POST.(new CommentManager($this->config))->getCommentById($id)->getPostId());
    }

    public function invalidateComment()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $resultCheck = $this->session->checkToken($token);
        
        switch ($resultCheck) {
            case TokenManager::TOKEN_VALID:
                break;
            case TokenManager::TOKEN_EXPIRED:
                throw new \Exception("Token Expiré");
                break;
            case TokenManager::TOKEN_INVALID:
                throw new \Exception("Token non valide");
                break;
        }
        if ($id == false) {
            throw new \Exception("Commentaire non valide");
        }
        (new CommentManager($this->config))->invalidateComment($id);
        // $this->redirect($this::URL_POST.(new CommentManager($this->config))->getCommentById($id)->getPostId());
    }

    public function removeComment()
    {
        $commentId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $comment = (new CommentManager($this->config))->getCommentById($commentId);
        (new CommentManager($this->config))->remove($comment);
    }
}
