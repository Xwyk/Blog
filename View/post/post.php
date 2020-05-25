<?php
	ob_start();
    require __DIR__.'/../templates/posts.php';
	$article=ob_get_clean();

    ob_start();
	require __DIR__.'/../parts/navbar.php';
    $navbar=ob_get_clean();

    ob_start();
	require __DIR__.'/../parts/footer.php';
    $footer=ob_get_clean();
// $art=password_hash("bvnxu9447", PASSWORD_DEFAULT);

require __DIR__.'/../pages/post.php';
