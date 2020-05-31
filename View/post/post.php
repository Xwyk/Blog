<?php
	ob_start();
    require __DIR__.'/../templates/posts.php';
	$content=ob_get_clean();
// $art=password_hash("bvnxu9447", PASSWORD_DEFAULT);

require __DIR__.'/../pages/template.php';
