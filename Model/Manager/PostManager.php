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
   			$postsArray[] = self::createFromArray($data);
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
		$resultPosts = $posts->fetch();
		if(!$resultPosts){
			throw new PostNotFoundException($postId);
		}
			$resultComments = CommentManager::getAllCommentsByPost($postId);

		$ret = self::createFromArray($resultPosts, $resultComments);
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

	static public function createFromArray(array $data, array $comments = null)
	{
		return new Post([
   				'id' => $data['postId'],
				'chapo' => $data['postChapo'],
				'title' => $data['postTitle'],
				'creation_date' => $data['postCreationDate'],
				'modification_date' => $data['postModificationDate'],
				'author' => UserManager::createFromArray($data),
				'comments' => $comments
   			]);
	}
	

	static public function remove(Post $post)
	{
		$request = 'DELETE FROM post
					WHERE id = :id ;';
		$result = self::executeRequest($request, ['id'=>$post->getId()]);
		return $result;				    
	}

}