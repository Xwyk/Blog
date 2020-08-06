<?php
use Blog\Framework\Session;
?>
<!DOCTYPE html>
<html>
<head>
	<title><?= $mainTitle ?? "Titre par défaut" ?></title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap Core CSS -->
     <link href="Common/themes/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="Common/themes/css/freelancer.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="Common/themes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <?= $preBody ?? ""?>
</head>
<body>
	<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/#page-top">Florian LEBOUL</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="/#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="/#portfolio">Portfolio</a>
                    </li>
                    <li class="page-scroll">
                        <a href="/#about">A propos</a>
                    </li>
                    <li class="page-scroll">
                        <a href="/#contact">Contact</a>
                    </li>
                    <li>
                        <?php
                            if ($session->isAuthenticated()) {
                        ?>
                        <a href="/?action=logout">Déconnexion</a>
                        <?php
                            }
                            else{
                        ?>
                        <a href="/?action=login">Connexion</a>
                        <?php
                            }
                        ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
	<?= $content ?>
	<!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p>3481 Melrose Place
                            <br>Beverly Hills, CA 90210</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Accès membre</h3>
                        <?php
                            if ($session->isAuthenticated()) {
                                if ($session->isAdmin()) {
                        ?>
                        <p>Accéder à <a href="/?action=admin">l'interface d'administration</a>.</p>
                        <?php
                                }
                        ?>
                        <p><a href="/?action=logout">Déconnexion</a>.</p>
                        <?php
                            }
                            else{
                        ?>
                        <p>Se <a href="/?action=login">connecter</a>.</p>
                    </div>
                        <?php
                            }
                        ?>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Your Website 2016
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- Portfolio Modals -->
    <!-- <?= $posts ?> -->

    <!-- jQuery -->
    <script src="Common/themes/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="Common/themes/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="Common/themes/js/jqBootstrapValidation.js"></script>
    <script src="Common/themes/js/contact_me.js"></script>


    <!-- Theme JavaScript -->
    <script src="Common/themes/js/freelancer.min.js"></script>
    <?= $postBody ?? ""?>
</body>
</html> 