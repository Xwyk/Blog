<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Comment;
/**
 * 
 */
class CommentManager extends Manager
{
	const BASE_REQUEST = 'SELECT comment.id AS commentId,
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
	
	public function getAllCommentsByPost(int $postId) : array
	{

		$requestComments = $this::BASE_REQUEST.'WHERE post.id = :id ;';

		$comments = $this->executeRequest($requestComments, ['id'=>$postId]);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = $this->createFromArray($data);
        }

		return $resultComments;
	}

	public function getAllComments() : array
	{

		$requestComments = $this::BASE_REQUEST;

		$comments = $this->executeRequest($requestComments);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = $this->createFromArray($data);
        }
		return $resultComments;
	}

	public function getValidCommentsByPost(int $postId) : array
	{
		$requestComments = $this::BASE_REQUEST.'WHERE post.id = :id 
												AND comment.isValid = 1;';
		$comments = $this->executeRequest($requestComments, ['id'=>$postId]);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = $this->createFromArray($data);
        }
		
		return $resultComments;
	}

	public function getAllValidComments() : array
	{
		$requestComments = $this::BASE_REQUEST.'WHERE comment.isValid = 1;';

		$comments = $this->executeRequest($requestComments);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = $this->createFromArray($data);
        }
		
		return $resultComments;
	}

	public function getInvalidCommentsByPost(int $postId) : array
	{
		$requestComments = $this::BASE_REQUEST.'WHERE post.id = :id 
												AND comment.isValid = 0;';

		$comments = $this->executeRequest($requestComments, [':id'=>$postId]);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = $this->createFromArray($data);
        }
		
		return $resultComments;
	}

	public function getAllInvalidComments() : array
	{
		$requestComments = $this::BASE_REQUEST.'WHERE comment.isValid = 0;';

		$comments = $this->executeRequest($requestComments);
		
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = $this->createFromArray($data);
        }
		
		return $resultComments;
	}

	public function getCommentById(int $commentId)
	{
		$requestComments = $this::BASE_REQUEST.'WHERE comment.id = :id ;';

		$comments = $this->executeRequest($requestComments, [':id'=>$commentId]);
		$ret=null;
		$resultRequest = $comments->fetch();
		if (!$resultRequest) {
			throw new \Exception('commentaire non trouvé');
		}
   		$ret = $this->createFromArray($resultRequest);
		
		return $ret;
	}

	public function validateComment(int $commentId){
		$requestValidate = 'UPDATE comment
							SET isValid = 1
							WHERE id = :id;';
		$result = $this->executeRequest($requestValidate, [':id' => $commentId]);
		return $result;
	}

	public function invalidateComment(int $commentId){
		$requestValidate = 'UPDATE comment
							SET isValid = 0
							WHERE id = :id;';
		$result = $this->executeRequest($requestValidate, [':id' => $commentId]);
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
		$result = $this->executeRequest($request, [':content' => $comment->getContent(), 
												  ':author' => $comment->getAuthor()->getId(),
												  ':post' => $comment->getPostId()]);
		return $result;				    
	}

	public function remove(Comment $comment)
	{
		$request = 'DELETE FROM comment
					WHERE id = :id ;';
		$result = $this->executeRequest($request, ['id'=>$comment->getId()]);
		return $result;				    
	}

	public function createFromArray(array $data)
	{
		return new Comment([
   				'id' => $data['commentId'],
				'creationDate' => $data['commentCreationDate'],
				'content' => $data['commentContent'],
				'author' => (new UserManager($this->config))->createFromArray($data),
				'isValid' => $data['commentValid'],
				'postId' => $data['commentPostId'] ?? null
			]);
	}
}