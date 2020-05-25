<?php
// Html string who contains data for posts
$posts="";
// Html string who contains data for posts grid
$caption="";

// For each post in database, create post and post entry in post grid 
foreach ($articles as $key => $article) {
	// Setting articles for post
    $id=$article->getId();
    $title=$article->getTitle();
    $chapo=$article->getChapo();
    $modificationDate=$article->getModificationDate();
    if (!is_null($modificationDate))
    	$modificationDate=$modificationDate->format('Y-m-d H:i');
    else
    	$modificationDate=$article->getCreationDate();


    // Calling template for posts grid
	ob_start();
	require __DIR__.'/../templates/postsGrid.php';
    $caption.=ob_get_clean();


    // Calling template for posts
	//ob_start();
    //require __DIR__.'/../templates/posts.php';
	//$posts.=ob_get_clean();
}

    ob_start();
	require __DIR__.'/../parts/navbar.php';
    $navbar=ob_get_clean();

    ob_start();
	require __DIR__.'/../parts/footer.php';
    $footer=ob_get_clean();
// $art=password_hash("bvnxu9447", PASSWORD_DEFAULT);

require __DIR__.'/../pages/home.php';
