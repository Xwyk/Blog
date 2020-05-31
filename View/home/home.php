<?php
ob_start();
require __DIR__.'/../templates/postsGrid.php';
   $caption=ob_get_clean();
// $art=password_hash("bvnxu9447", PASSWORD_DEFAULT);
ob_start();
require __DIR__.'/../content/home.php';
$content=ob_get_clean();
require __DIR__.'/../pages/template.php';
