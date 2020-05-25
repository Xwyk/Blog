<?php
// $id='bonjour';
$title = $result['post']->getTitle();
$content = $result['post']->getContent();
$author = $result['post']->getAuthor()->getPseudo();
$creationDate = $result['post']->getCreationDate();
$modificationDate = $result['post']->getModificationDate();
if (!is_null($creationDate))
        $creationDate=$creationDate->format('Y-m-d H:i');
else
    $creationDate='Non défini';
if (!is_null($modificationDate))
        $modificationDate=$modificationDate->format('Y-m-d H:i');
else
    $modificationDate=$creationDate;
    // Calling template for posts
    ob_start();
    foreach ($commentsList as $comment) {
        $userId = '69';
        $userFullName = "bonjour";
        $commentDate = $comment->getCreationDate();
        $commentContent = $comment->getContent();

        if (!is_null($commentDate))
        $commentDate=$commentDate->format('Y-m-d H:i');
        else
            $commentDate='Non défini';
        require __DIR__.'/../templates/comment.php';
        
    }
    $comments=ob_get_clean();

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
