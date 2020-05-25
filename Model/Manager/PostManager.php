<?php
namespace Blog\Model\Manager;

use Blog\Framework\Manager;
use Blog\Model\Post;
use Blog\Model\User;
use Blog\Exceptions\PostNotFoundException;
/**
 * 
 */
class PostManager extends Manager
{
	static public function getAllPosts()
	{
		// $request = 'SELECT post.id, chapo, title, content, author, post.creation_date, post.modification_date, user.pseudo FROM post 
					// INNER JOIN user ON post.author = user.id 
					// ORDER BY date_creation DESC';
        $request = 'SELECT * FROM post;';
        $posts = self::executeRequest($request);
        $postsArray = [];
        while ($data = $posts->fetch()){
        	$postsArray[] = new Post($data);
        }
        	
        return $postsArray;
	}

	static public function getPostById(int $postId) : array
	{
		$request = 'SELECT post.id, chapo, title, content, author, post.creation_date, post.modification_date, 
						   user.id as userId, pseudo, first_name, last_name, mail_address
					FROM post INNER JOIN user
					ON author = user.id 
					WHERE post.id = :id ;';
		$posts = self::executeRequest($request, ['id'=>$postId]);
		$data = $posts->fetch();
		if( !$data){
			throw new PostNotFoundException($postId);
		}
		$ret = [
			'post' => new Post([
				'id' => $data['id'],
				'chapo' => $data['chapo'],
				'title' => $data['title'],
				'content' => $data['content'],
				'creation_date' => $data['creation_date'],
				'modification_date' => $data['modification_date'],
				'author' => new User([
					'id' => $data['userId'],
					'pseudo' => $data['pseudo'],
					'first_name' => $data['first_name'],
					'last_name' => $data['last_name'],
					'mail_address' => $data['mail_address']
				])
			])
		];
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