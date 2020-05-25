<?php
namespace Blog\Model\Manager;
require __DIR__.'/../../Framework/Manager.php';
// require __DIR__.'/../Post.php';

use Blog\Framework\Manager;
use Blog\Model\Post;
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
		$request = 'SELECT post.id, chapo, title, content, author, post.creation_date, post.modification_date, user.pseudo
					FROM post INNER JOIN user 
					ON post.author = user.id 
					WHERE post.id = :id ;';
		$posts = self::executeRequest($request, ['id'=>$postId]);
		$data = $posts->fetch();
		if( !$data){
			throw new PostNotFoundException($postId);
		}
		$ret = ['user' => new Post($data), 'author' => $data['pseudo']];
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