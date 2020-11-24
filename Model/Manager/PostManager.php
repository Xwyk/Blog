<?php

namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Post;
use Blog\Exceptions\PostNotFoundException;

/**
 *
 */
class PostManager extends Manager
{
    public const COMMENTS_VALID   = 1;
    public const COMMENTS_INVALID = 2 ;
    public const COMMENTS_ALL     = 3;
    
    protected const BASE_REQUEST  = 'SELECT post.id AS postId, 
                                   post.chapo AS postChapo, 
                                   post.title AS postTitle, 
                                   post.content AS postContent, 
                                   post.author AS postAuthor, 
                                   post.creation_date AS postCreationDate, 
                                   post.modification_date AS postModificationDate, 
                                   post.picture AS postPicture, 
                                   
                                   user.id AS userId, 
                                   user.pseudo AS userPseudo, 
                                   user.first_name AS userFirstName, 
                                   user.last_name AS userLastName, 
                                   user.mail_address AS userMailAddress
                           
                                FROM post 
                                INNER JOIN user
                                ON post.author = user.id ';

    public function getAll()
    {
        $request    = $this::BASE_REQUEST;
        $posts      = $this->executeRequest($request);
        $postsArray = [];
        while ($data = $posts->fetch()) {
            $postsArray[] = $this->createFromArray($data);
        }
        return $postsArray;
    }

    public function getById(int $postId, int $commentsValidity = PostManager::COMMENTS_VALID)
    {
        $requestPosts = $this::BASE_REQUEST.'WHERE post.id = :id ;';
        $posts        = $this->executeRequest($requestPosts, ['id'=>$postId]);
        $resultPosts  = $posts->fetch();
        if (!$resultPosts) {
            throw new PostNotFoundException($postId);
        }
        $commentManager = new CommentManager($this->config);
        switch ($commentsValidity) {
            case $this::COMMENTS_INVALID:
                $resultComments = $commentManager->getInvalidByPost($postId);
                break;
            case $this::COMMENTS_ALL:
                $resultComments = $commentManager->getAllByPost($postId);
                break;
            case $this::COMMENTS_VALID:
            default:
                $resultComments = $commentManager->getValidByPost($postId);
                break;
        }
        $ret = $this->createFromArray($resultPosts, $resultComments);
        return $ret;
    }

    public function add(Post $post)
    {
        $request = 'INSERT INTO post (chapo, 
                                      title,
                                      content,
                                      picture,
                                      author)
                    VALUES (:chapo, 
                            :title, 
                            :content, 
                            :picture, 
                            :author);';
                    
        $result = $this->executeRequest($request, [
            'chapo'   => $post->getChapo(),
            'title'   => $post->getTitle(),
            'content' => $post->getContent(),
            'picture' => $post->getPicture(),
            'author'  => $post->getAuthor()->getId()
        ]);
        return $result;
    }

    public function createFromArray(array $data, array $comments = null)
    {
        return new Post([
            'id'                => $data['postId']??null,
            'chapo'             => $data['postChapo'],
            'title'             => $data['postTitle'],
            'content'           => $data['postContent'],
            'picture'           => $data['postPicture']??null,
            'creation_date'     => $data['postCreationDate']??null,
            'modification_date' => $data['postModificationDate']??null,
            'picture'           => $data['postPicture']??null,
            'author'            => (new UserManager($this->config))->createFromArray($data),
            'comments'          => $comments
        ]);
    }
    
    public function remove(Post $post)
    {
        // $request = 'DELETE blog.comment.*, blog.post.*
        //             FROM blog.comment 
        //             INNER JOIN blog.post 
        //             ON blog.post.id = blog.comment.post 
        //             WHERE blog.post.id = :id';
        $request = 'DELETE blog.post.*
                    FROM blog.post 
                    WHERE blog.post.id = :id';
        $result  = $this->executeRequest($request, ['id'=>$post->getId()]);
        return $result;
    }

    public function update(Post $post)
    {
        $request = 'UPDATE post
                    SET chapo     = :chapo,
                        title     = :title,
                        content   = :content,
                        picture   = :picture
                    WHERE id = :id;';
        $result  = $this->executeRequest($request, [
            'chapo'   => $post->getChapo(),
            'title'   => $post->getTitle(),
            'content' => $post->getContent(),
            'picture' => $post->getPicture(),
            'id'      => $post->getId()
        ]);
        return $result;
    }
}
