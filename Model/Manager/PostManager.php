<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Post;
use Blog\Model\User;
use Blog\Model\Comment;
use Blog\Exceptions\PostNotFoundException;
/**
 * 
 */
class PostManager extends Manager
{
	static public function getAllPosts()
	{
        $request = 'SELECT post.id AS postId, 
						   post.chapo AS postChapo, 
						   post.title AS postTitle, 
						   post.author AS postAuthor, 
						   post.creation_date AS postCreationDate, 
						   post.modification_date AS postModificationDate, 
						   
						   user.id AS userId, 
						   user.pseudo AS userPseudo, 
						   user.first_name AS userFirstName, 
						   user.last_name AS userLastName, 
						   user.mail_address AS userMailAddress
						 
					FROM post 
					INNER JOIN user
					ON author = user.id;';

        $posts = self::executeRequest($request);
        $postsArray = [];
        while ($data = $posts->fetch()){
   			$postsArray[] = new Post([
   				'id' => $data['postId'],
				'chapo' => $data['postChapo'],
				'title' => $data['postTitle'],
				'creation_date' => $data['postCreationDate'],
				'modification_date' => $data['postModificationDate'],
				'author' => new User([
					'id' => $data['userId'],
					'pseudo' => $data['userPseudo'],
					'first_name' => $data['userFirstName'],
					'last_name' => $data['userLastName'],
					'mail_address' => $data['userMailAddress']
				]),
   			]);
        }
        	
        return $postsArray;
	}

	static public function getPostById(int $postId)
	{
		$requestPosts = 'SELECT post.id AS postId, 
						   		post.chapo AS postChapo, 
						   		post.title AS postTitle, 
						   		post.content AS postContent, 
						   		post.author AS postAuthor, 
						   		post.creation_date AS postCreationDate, 
						   		post.modification_date AS postModificationDate, 
						   		
						   		user.id AS userId, 
						   		user.pseudo AS userPseudo, 
						   		user.first_name AS userFirstName, 
						   		user.last_name AS userLastName, 
						   		user.mail_address AS userMailAddress
						   
								FROM post 
								INNER JOIN user
								ON post.author = user.id
								WHERE post.id = :id ;';
		$posts = self::executeRequest($requestPosts, ['id'=>$postId]);
		$requestComments = 'SELECT comment.id AS commentId,
						   		   comment.content AS commentContent,
						   		   comment.isValid AS commentValid,
						   		   comment.author AS commentAuthor,
						   		   comment.creation_date AS commentCreationDate,
		   
						   		   user.id AS authorId, 
						   		   user.pseudo AS authorPseudo, 
						   		   user.first_name AS authorFirstName, 
						   		   user.last_name AS authorLastName, 
						   		   user.mail_address AS authorMailAddress
						   
							FROM comment 
							INNER JOIN post
							ON comment.post = post.id
							INNER JOIN user
							ON comment.author = user.id
							WHERE post.id = :id ;';

		$comments = self::executeRequest($requestComments, ['id'=>$postId]);
		$resultPosts = $posts->fetch();
		if(!$resultPosts){
			throw new PostNotFoundException($postId);
		}
		$resultComments=[];
		while ($data = $comments->fetch()){
   			$resultComments[] = new Comment([
   				'id' => $data['commentId'],
				'creationDate' => $data['commentCreationDate'],
				'content' => $data['commentContent'],
				'author' => new User([
					'id' => $data['authorId'],
					'pseudo' => $data['authorPseudo'],
					'first_name' => $data['authorFirstName'],
					'last_name' => $data['authorLastName'],
					'mail_address' => $data['authorMailAddress']
				]),
				'isValid' => $data['commentValid']
   			]);
        }

		$ret = new Post([
				'id' => $resultPosts['postId'],
				'chapo' => $resultPosts['postChapo'],
				'title' => $resultPosts['postTitle'],
				'content' => $resultPosts['postContent'],
				'creation_date' => $resultPosts['postCreationDate'],
				'modification_date' => $resultPosts['postModificationDate'],
				'author' => new User([
					'id' => $resultPosts['userId'],
					'pseudo' => $resultPosts['userPseudo'],
					'first_name' => $resultPosts['userFirstName'],
					'last_name' => $resultPosts['userLastName'],
					'mail_address' => $resultPosts['userMailAddress']
				]),
				'comments' => $resultComments
			]);
		return $ret;
	}

	static public function add(Post $post)
	{
		$request = 'INSERT INTO post (chapo, 
									  title,
									  content,
									  author)
					VALUES (:chapo, 
							:title, 
							:content, 
							:author);';
					
		$result = self::executeRequest($request, ['chapo' => $post->getChapo(), 
												 'title' => $post->getTitle(),
												 'content' => $post->getContent(),
												 'author' => $post->getAuthor()]);
		return $result;				    
	}

	static public function remove(Post $post)
	{
		$request = 'DELETE FROM post
					WHERE id = :id ;';
		$result = self::executeRequest($request, ['id'=>$post->getId()]);
		return $result;				    
	}

}