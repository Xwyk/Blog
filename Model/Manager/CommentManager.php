<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Comment;
/**
 * 
 */
class CommentManager extends Manager
{
	
	static public function getCommentsByPost(int $postId) : array
	{
		$request = 'SELECT * FROM comment 
					WHERE post = :id;';
		$result = self::executeRequest($request, ['id' => $postId]);
		$commentsArray=[];
		while ($data = $result->fetch()){
        	$commentsArray[] = new Comment($data);
        }
		return $commentsArray;
	}

	static public function add(Comment $comment)
	{
		$request = 'INSERT INTO comment (content, 
									     author,
									     post)
					VALUES (:content,
							:author,
							:post);';
					
		$result = self::executeRequest($request, ['content' => $comment->getContent(), 
												 'post' => $comment->getPostId()]);
		return $result;				    
	}

	static public function remove(Comment $comment)
	{
		$request = 'DELETE FROM comment
					WHERE id = :id ;';
		$result = self::executeRequest($request, ['id'=>$comment->getId()]);
		return $result;				    
	}
}