<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Model\Manager\CommentManager;
use Blog\Model\Comment;
use Blog\Framework\View;
use Blog\Framework\Configuration;
use Blog\Framework\Session;

class PostController extends Controller
{
    
    protected const IMAGE_MAX_SIZE = 10000000;
    protected const ALLOWED_EXTENSIONS = [
        'png',
        'jpg',
        'jpeg',
        'webp',
    ];
    public function display()
    {
        $postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($postId == false) {
            throw new PostNotFoundException($postId);
        }
        $post = (new PostManager($this->config))->getPostById($postId);
        $this->render($this::VIEW_POST, ['post' => $post, "mainTitle"=>$post->getTitle()]);
    }

    public function addPost()
    {
        if (!$this->isAdmin()) {
            if (!$this->isUser()) {
                $this->redirect($this::URL_LOGIN);
            }
            throw new \Exception("Les droits administrateur sont nécéssaires", 1);
        }
        $validate = filter_input(INPUT_POST, 'validate', FILTER_VALIDATE_INT);
        if (!$validate) {
            $this->render($this::VIEW_ADDPOST);
            return;
        }
        $imageDir = '.\images\\';
        $imageName=md5(uniqid());
        $imageExtension = pathinfo($_FILES['postImage']['name'], PATHINFO_EXTENSION);
        // if (in_array($imageExtension, $this::ALLOWED_EXTENSIONS)) {
        //  throw new \Exception("Extension non authorisée", 1);
        // }
        if ($_FILES['postImage']['size'] > $this::IMAGE_MAX_SIZE) {
            throw new \Exception("L'image est trop grande", 1);
        }
        if (!move_uploaded_file($_FILES['postImage']['tmp_name'], $imageDir.$imageName.'.'.$imageExtension)) {
            throw new \Exception("Impossible de déplacer l'image", 1);
        }
        
        $newpost = (new PostManager($this->config))->createFromArray([
            'postTitle'=>filter_input(INPUT_POST, 'postTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'postChapo'=>filter_input(INPUT_POST, 'postChapo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'postContent'=>filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'postPicture'=>$imageDir.$imageName.'.'.$imageExtension,
            'userId'=>$this->session->getAttribute('user')->getId(),
            'userPseudo'=>$this->session->getAttribute('user')->getPseudo(),
            'userFirstName'=>$this->session->getAttribute('user')->getFirstName(),
            'userLastName'=>$this->session->getAttribute('user')->getLastName(),
            'userMailAddress'=>$this->session->getAttribute('user')->getMailAddress()
        ]);
        (new PostManager($this->config))->add($newpost);
        //$this->redirect(self::URL_HOME);
    }
}
