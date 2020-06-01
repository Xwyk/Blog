<?php

namespace Blog\View;

/**
 * 
 */
class View
{
	static public function render(string $view, array $parameters = null)
	{
		ob_start();
		extract($parameters);
		require __DIR__.'/content/'.$view.'.php';



		// switch ($view) {
		// 	case 'post':
		// 		$post = $parameters['post'];
		// 		require __DIR__.'/content/post.php';
		// 		break;
		// 	case 'login':
		// 		require __DIR__.'/content/login.php';
		// 		break;
		// 	case 'home':
		// 		$articles = $parameters['articles'];
		// 		require __DIR__.'/content/home.php';
		// 		break;
		// 	default:
		// 		# code...
		// 		break;
		// }
		$content=ob_get_clean();
		require __DIR__.'/pages/template.php';
	}
}