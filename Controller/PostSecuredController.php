<?php

namespace Blog\Controller;

use Blog\Framework\SecuredController;
use Blog\Model\Manager\PostManager;
use Blog\Exceptions\NotEnoughRightsException;
use Blog\Exceptions\TooLargeImageException;
use Blog\Exceptions\MoveImageException;
use Blog\Exceptions\PostNotFoundException;

class PostSecuredController extends SecuredController
{
    public const VIEW_ADDPOST  = "addPost";
    public const VIEW_EDITPOST = "editPost";
    public const VIEW_POST     = "post";
    protected const IMAGE_MAX_SIZE     = 10000000;
    protected const ALLOWED_EXTENSIONS = [
        'png',
        'jpg',
        'jpeg',
        'webp'
    ];

    public function displayAddPostPage()
    {
        if (!$this->isAdmin()) {
            if (!$this->isUser()) {
                $this->redirect('../'.$this->router->url('login_page').'?redirect='.urlencode($this->routes['post_add_page']['url']));
            }
            throw new NotEnoughRightsException();
        }
        $this->render($this::VIEW_ADDPOST);
    }

    public function addPostRequest()
    {
        if (!$this->isAdmin()) {
            if (!$this->isUser()) {
                $this->redirect('../'.$this->router->url('login_page').'?redirect='.urlencode($this->routes['post_add_page']['url']));
            }
            throw new NotEnoughRightsException();
        }

        $newpost = (new PostManager($this->config))->createFromArray([
            'postTitle'       =>$this->router->request->getPostValue('postTitle'),
            'postChapo'       =>$this->router->request->getPostValue('postChapo'),
            'postContent'     =>$this->router->request->getPostValue('postContent'),
            'postPicture'     =>$this->getPicturePath(),
            'userId'          =>$this->session->getAttribute('user')->getId(),
            'userPseudo'      =>$this->session->getAttribute('user')->getPseudo(),
            'userFirstName'   =>$this->session->getAttribute('user')->getFirstName(),
            'userLastName'    =>$this->session->getAttribute('user')->getLastName(),
            'userMailAddress' =>$this->session->getAttribute('user')->getMailAddress()
        ]);
        (new PostManager($this->config))->add($newpost);
        $this->redirect($this->router->url('home_page'));
    }

    public function displayEditPostPage(int $postId)
    {
        if (!$this->isAdmin()) {
            if (!$this->isUser()) {
                $this->redirect('../'.$this->router->url('login_page').'?redirect='.urlencode($this->routes['post_edit_page']['url']));
            }
            throw new NotEnoughRightsException();
        }
        $this->render($this::VIEW_EDITPOST, ["post"=>(new PostManager($this->config))->getById($postId)]);
    }

    public function editPostRequest(int $postId)
    {
        if (!$this->isAdmin()) {
            if (!$this->isUser()) {
                $this->redirect('../'.$this->router->url('login_page').'?redirect='.urlencode($this->routes['post_edit_page']['url']));
            }
            throw new NotEnoughRightsException();
        }

        $postToUpdate = (new PostManager($this->config))->getById($postId);
        $postToUpdate->setTitle($this->router->request->getPostValue('postTitle'));
        $postToUpdate->setChapo($this->router->request->getPostValue('postChapo'));
        $postToUpdate->setContent($this->router->request->getPostValue('postContent'));

        $imgPath = $this->getPicturePath();
        if ($imgPath) {
            if (is_string($imgPath)) {
                $postToUpdate->setPicture($imgPath);
            }
            //error while getting image
        }

        (new PostManager($this->config))->update($postToUpdate);
        //TODO 
        $this->redirect($this->router->url('post_page',['id' => $postId]));
    }

    protected function getPicturePath()
    {
        $image = $this->router->request->getFilesValue('postImage') ?? null;
        if ($image['error'] == 0) {
            $imageDir = '.\images\\';
            $imageName=md5(uniqid());
            $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
            // if (in_array($imageExtension, $this::ALLOWED_EXTENSIONS)) {
            //  throw new \Exception("Extension non authorisée", 1);
            // }
            if ($image['size'] > $this::IMAGE_MAX_SIZE) {
                throw new TooLargeImageException();
            }
            if (!move_uploaded_file($image['tmp_name'], $imageDir.$imageName.'.'.$imageExtension)) {
                throw new MoveImageException();
            }
            return $imageDir.$imageName.'.'.$imageExtension;
        }
        return $image['error'];
    }


    /**
     * Remove a comment in database. Gets comment id value by url (GET)
     */
    public function remove(int $postId)
    {
        $error = null;
        //Validate comment
        try{
            $this->checkAdminRights();
            $post = (new PostManager($this->config))->getById($postId);
            $response['rowAffecteds'] =  (new PostManager($this->config))->remove($post)->rowCount();
        } catch (\Exception $e){
            $error = $e;
        }
        $response['message'] = $error? $error->getMessage():'OK';
        $response['code']    = $error? $error->getCode() : '0';
        $this->render('request', [
            'response' => $response
        ]);
        //$this->redirect($this::URL_ADMIN);
    }
}
