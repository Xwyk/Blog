<?php

namespace Blog\Controller;

use Blog\Framework\Controller;
use Blog\Model\Manager\PostManager;
use Blog\Exceptions\PostNotFoundException;

class PostController extends Controller
{
    public const VIEW_POS = "post";

    public function displayPostById(int $postId)
    {
        if ($postId <= 0) {
            throw new PostNotFoundException($postId);
        }
        $post = (new PostManager($this->config))->getById($postId);
        $this->render($this::VIEW_POST, ['post' => $post, "mainTitle"=>$post->getTitle()]);
    }
}
