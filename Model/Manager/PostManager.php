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
	const VALID_COMMENTS = 1;
    const INVALID_COMMENTS = 2 ;
    const ALL_COMMENTS = 3;

	public function getAllPosts()
	{
        $request = 'SELECT post.id AS postId, 
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
					ON author = user.id;';

        $posts = $this->executeRequest($request);
        $postsArray = [];
        while ($data = $posts->fetch()){
   			$postsArray[] = $this->createFromArray($data);
        }
        return $postsArray;
	}

	public function getPostById(int $postId, int $commentsValidity=PostManager::VALID_COMMENTS)
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
		$posts = $this->executeRequest($requestPosts, ['id'=>$postId]);
		$resultPosts = $posts->fetch();
		if(!$resultPosts){
			throw new PostNotFoundException($postId);
		}
		switch ($commentsValidity) {
			case $this::INVALID_COMMENTS:
				$resultComments = (new CommentManager($this->config))->getInvalidCommentsByPost($postId);
				break;
			case $this::ALL_COMMENTS:
				$resultComments = (new CommentManager($this->config))->getAllCommentsByPost($postId);
				break;
			default:
				$resultComments = (new CommentManager($this->config))->getValidCommentsByPost($postId);
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
									  author)
					VALUES (:chapo, 
							:title, 
							:content, 
							:author);';
					
		$result = $this->executeRequest($request, ['chapo' => $post->getChapo(), 
												 'title' => $post->getTitle(),
												 'content' => $post->getContent(),
												 'author' => $post->getAuthor()->getId()]);
		return $result;				    
	}

	public function createFromArray(array $data, array $comments = null)
	{
		return new Post([
   				'id' => $data['postId']??null,
				'chapo' => $data['postChapo'],
				'title' => $data['postTitle'],
				'content' => $data['postContent'],
				'creation_date' => $data['postCreationDate']??null,
				'modification_date' => $data['postModificationDate']??null,
				'author' => (new UserManager($this->config))->createFromArray($data),
				'comments' => $comments
   			]);
	}
	

	public function remove(Post $post)
	{
		$request = 'DELETE FROM post
					WHERE id = :id ;';
		$result = $this->executeRequest($request, ['id'=>$post->getId()]);
		return $result;				    
	}

}