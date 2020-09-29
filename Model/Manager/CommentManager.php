<?php

namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Exceptions\CommentNotFoundException;
use Blog\Model\Comment;

/**
 *
 */
class CommentManager extends Manager
{

    public const COMMENTS_VALID = 1;
    public const COMMENTS_INVALID = 2;
    public const COMMENTS_ALL = 3;
    protected const BASE_REQUEST = 'SELECT comment.id AS commentId,
                                      comment.content AS commentContent,
                                      comment.isValid AS commentValid,
                                      comment.author AS commentAuthor,
                                      comment.creation_date AS commentCreationDate,
                                      comment.post AS commentPostId,

                                      user.id AS userId, 
                                      user.pseudo AS userPseudo, 
                                      user.first_name AS userFirstName, 
                                      user.last_name AS userLastName, 
                                      user.mail_address AS userMailAddress
                           
                            FROM comment 
                            INNER JOIN post
                            ON comment.post = post.id
                            INNER JOIN user
                            ON comment.author = user.id ';
    
    

    protected function get(int $selector, int $postId = -1)
    {
        switch ($selector) {
            case $this::COMMENTS_ALL:
                if ($postId == -1) {
                    $requestComments = $this::BASE_REQUEST;
                    break;
                }
                $requestComments = $this::BASE_REQUEST.'WHERE post.id = :id ;';
                break;
            case $this::COMMENTS_INVALID:
                if ($postId == -1) {
                    $requestComments = $this::BASE_REQUEST.'WHERE comment.isValid = 0;';
                    break;
                }
                $requestComments = $this::BASE_REQUEST.'WHERE post.id = :id 
                                                        AND comment.isValid = 0;';
                break;
            case $this::COMMENTS_VALID:
            default:
                if ($postId == -1) {
                    $requestComments = $this::BASE_REQUEST.'WHERE comment.isValid = 1;';
                    break;
                }
                $requestComments = $this::BASE_REQUEST.'WHERE post.id = :id 
                                                        AND comment.isValid = 1;';
                break;
        }
        if ($postId == -1) {
            return $this->formatResponse($this->executeRequest($requestComments));
        }
        return $this->formatResponse($this->executeRequest($requestComments, [':id'=>$postId]));
    }

    public function getAll(): array
    {
        return $this->get($this::COMMENTS_ALL);
    }

    public function getAllValid(): array
    {
        return $this->get($this::COMMENTS_VALID);
    }

    public function getAllInvalid(): array
    {
        return $this->get($this::COMMENTS_INVALID);
    }

    public function getAllByPost(int $postId): array
    {
        return $this->get($this::COMMENTS_ALL, $postId);
    }

    public function getValidByPost(int $postId): array
    {
        return $this->get($this::COMMENTS_VALID, $postId);
    }

    public function getInvalidByPost(int $postId): array
    {
        return $this->get($this::COMMENTS_INVALID, $postId);
    }

    private function formatResponse($comments): array
    {
        $result = [];
        while ($data = $comments->fetch()) {
            $result[] = $this->createFromArray($data);
        }
        return $result;
    }

    public function getById(int $commentId)
    {
        $requestComments = $this::BASE_REQUEST.'WHERE comment.id = :id ;';

        $comments = $this->executeRequest($requestComments, [':id'=>$commentId]);
        $ret=null;
        $resultRequest = $comments->fetch();
        if (!$resultRequest) {
            throw new CommentNotFoundException($commentId);
        }
        $ret = $this->createFromArray($resultRequest);
        
        return $ret;
    }

    public function validate(int $commentId)
    {
        $request = 'UPDATE comment
                    SET isValid = 1
                    WHERE id = :id;';
        $result = $this->executeRequest($request, [':id' => $commentId]);
        return $result;
    }

    public function invalidate(int $commentId)
    {
        $request = 'UPDATE comment
                    SET isValid = 0
                    WHERE id = :id;';
        $result = $this->executeRequest($request, [':id' => $commentId]);
        return $result;
    }

    public function add(Comment $comment)
    {
        $request = 'INSERT INTO comment (content, 
                                         author,
                                         post)
                    VALUES (:content,
                            :author,
                            :post);';
        $result = $this->executeRequest($request, [
            ':content' => $comment->getContent(),
            ':author'  => $comment->getAuthor()->getId(),
            ':post'    => $comment->getPostId()
        ]);
        return $result;
    }

    public function remove(Comment $comment)
    {
        $request = 'DELETE FROM comment
                    WHERE id = :id ;';
        $result  = $this->executeRequest($request, ['id'=>$comment->getId()]);
        return $result;
    }

    public function createFromArray(array $data)
    {
        return new Comment([
            'id'           => $data['commentId'],
            'creationDate' => $data['commentCreationDate'],
            'content'      => $data['commentContent'],
            'author'       => (new UserManager($this->config))->createFromArray($data),
            'isValid'      => $data['commentValid'],
            'postId'       => $data['commentPostId'] ?? null
        ]);
    }
}
