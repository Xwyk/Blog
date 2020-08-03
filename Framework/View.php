<?php

namespace Blog\Framework;

/**
 * 
 */
class View

{
	static public function render(string $view, array $parameters = null)
	{
		if (isset($parameters)) {
			extract($parameters);
		}
		ob_start();
		require __DIR__.'/../View/content/'.$view.'.php';
		$content=ob_get_clean();

		require __DIR__.'/../View/pages/template.php';
	}
}