<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Comment;
/**
 * 
 */
class CommentManager extends Manager
{
	
	static public function getAllCommentsByPost(int $postId) : array
	{

		$requestComments = 'SELECT comment.id AS commentId,
						   		   comment.content AS commentContent,
						   		   comment.isValid AS commentValid,
						   		   comment.author AS commentAuthor,
						   		   comment.creation_date AS commentCreationDate,
		   
						   		   user.id AS userId, 
						   		   user.pseudo AS userPseudo, 
						   		   user.first_name AS userFirstName, 
						   		   user.last_name AS userLastName, 
						   		   user.mail_address AS userMailAddress
						   
							FROM comment 
							INNER JOIN post
							ON comment.post = post.id
							INNER JOIN user
							ON comment.author = user.id
							WHERE post.id = :id ;';

		$comments = self::executeRequest($requestComments, ['id'=>$postId]);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = CommentManager::createFromArray($data);
        }

		return $resultComments;
	}

	static public function getAllComments() : array
	{

		$requestComments = 'SELECT comment.id AS commentId,
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
							ON comment.author = user.id;';

		$comments = self::executeRequest($requestComments);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = CommentManager::createFromArray($data);
        }
		return $resultComments;
	}

	static public function getValidCommentsByPost(int $postId) : array
	{
		$requestComments = 'SELECT comment.id AS commentId,
						   		   comment.content AS commentContent,
						   		   comment.isValid AS commentValid,
						   		   comment.author AS commentAuthor,
						   		   comment.creation_date AS commentCreationDate,
		   
						   		   user.id AS userId, 
						   		   user.pseudo AS userPseudo, 
						   		   user.first_name AS userFirstName, 
						   		   user.last_name AS userLastName, 
						   		   user.mail_address AS userMailAddress
						   
							FROM comment 
							INNER JOIN post
							ON comment.post = post.id
							INNER JOIN user
							ON comment.author = user.id
							WHERE post.id = :id 
							AND comment.isValid = 1;';

		$comments = self::executeRequest($requestComments, ['id'=>$postId]);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = CommentManager::createFromArray($data);
        }
		
		return $resultComments;
	}

	static public function getAllValidComments() : array
	{
		$requestComments = 'SELECT comment.id AS commentId,
						   		   comment.content AS commentContent,
						   		   comment.isValid AS commentValid,
						   		   comment.author AS commentAuthor,
						   		   comment.creation_date AS commentCreationDate,
		   
						   		   user.id AS userId, 
						   		   user.pseudo AS userPseudo, 
						   		   user.first_name AS userFirstName, 
						   		   user.last_name AS userLastName, 
						   		   user.mail_address AS userMailAddress
						   
							FROM comment 
							INNER JOIN post
							ON comment.post = post.id
							INNER JOIN user
							ON comment.author = user.id
							AND comment.isValid = 1;';

		$comments = self::executeRequest($requestComments);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = CommentManager::createFromArray($data);
        }
		
		return $resultComments;
	}

	static public function getInvalidCommentsByPost(int $postId) : array
	{
		$requestComments = 'SELECT comment.id AS commentId,
						   		   comment.content AS commentContent,
						   		   comment.isValid AS commentValid,
						   		   comment.author AS commentAuthor,
						   		   comment.creation_date AS commentCreationDate,
		   
						   		   user.id AS userId, 
						   		   user.pseudo AS userPseudo, 
						   		   user.first_name AS userFirstName, 
						   		   user.last_name AS userLastName, 
						   		   user.mail_address AS userMailAddress
						   
							FROM comment 
							INNER JOIN post
							ON comment.post = post.id
							INNER JOIN user
							ON comment.author = user.id
							WHERE post.id = :id 
							AND comment.isValid = 0;';

		$comments = self::executeRequest($requestComments, [':id'=>$postId]);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = CommentManager::createFromArray($data);
        }
		
		return $resultComments;
	}

	static public function getAllInvalidComments() : array
	{
		$requestComments = 'SELECT comment.id AS commentId,
						   		   comment.content AS commentContent,
						   		   comment.isValid AS commentValid,
						   		   comment.author AS commentAuthor,
						   		   comment.creation_date AS commentCreationDate,
		   
						   		   user.id AS userId, 
						   		   user.pseudo AS userPseudo, 
						   		   user.first_name AS userFirstName, 
						   		   user.last_name AS userLastName, 
						   		   user.mail_address AS userMailAddress
						   
							FROM comment 
							INNER JOIN post
							ON comment.post = post.id
							INNER JOIN user
							ON comment.author = user.id
							AND comment.isValid = 0;';

		$comments = self::executeRequest($requestComments);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = CommentManager::createFromArray($data);
        }
		
		return $resultComments;
	}

	static public function getCommentById(int $commentId)
	{
		$requestComments = 'SELECT comment.id AS commentId,
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
							INNER JOIN user
							ON comment.author = user.id
							WHERE comment.id = :id ;';

		$comments = self::executeRequest($requestComments, [':id'=>$commentId]);
		$ret=null;
		$resultRequest = $comments->fetch();
		if (!$resultRequest) {
			throw new \Exception('commentaire non trouvé');
		}
   		$ret = CommentManager::createFromArray($resultRequest);
		
		return $ret;
	}

	static public function validateComment(int $commentId){
		$requestValidate = 'UPDATE comment
							SET isValid = 1
							WHERE id = :id;';
		$result = self::executeRequest($requestValidate, [':id' => $commentId]);
		return $result;
	}

	static public function invalidateComment(int $commentId){
		$requestValidate = 'UPDATE comment
							SET isValid = 0
							WHERE id = :id;';
		$result = self::executeRequest($requestValidate, [':id' => $commentId]);
		return $result;
	}

	static public function add(Comment $comment)
	{
		$request = 'INSERT INTO comment (content, 
									     author,
									     post)
					VALUES (:content,
							:author,
							:post);';
		$result = self::executeRequest($request, [':content' => $comment->getContent(), 
												  ':author' => $comment->getAuthor()->getId(),
												  ':post' => $comment->getPostId()]);
		return $result;				    
	}

	static public function remove(Comment $comment)
	{
		$request = 'DELETE FROM comment
					WHERE id = :id ;';
		$result = self::executeRequest($request, ['id'=>$comment->getId()]);
		return $result;				    
	}

	static public function createFromArray(array $data)
	{
		return new Comment([
   				'id' => $data['commentId'],
				'creationDate' => $data['commentCreationDate'],
				'content' => $data['commentContent'],
				'author' => UserManager::createFromArray($data),
				'isValid' => $data['commentValid'],
				'postId' => $data['commentPostId'] ?? null
			]);
	}
}