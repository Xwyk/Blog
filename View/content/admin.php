<?php
    $mainTitle = "Interface d'administrateion"
?>
<div class="portfolio-modal" >
    <div class="modal-content">
        <div class="container-fluid">
            <h1>Interface d'administration</h1>
            <div class="row">
                <div class="col-lg-2 col-lg-offset-1">
                    <ul class="nav nav-tabs text-left">
                        <li class="active"><a data-toggle="tab" href="#commentsManagement">Gestion des commentaires</a></li>
                        <li><a data-toggle="tab" href="#usersManagement">Gestion des utilisateurs</a></li>
                        <li><a href="/?action=addPost">Ajouter un article</a></li>
                    </ul>
                </div>
                <div class="col-lg-8">
                    <div class="container-fluid">
                        <div class="tab-content">
                            <div id="commentsManagement" class="tab-pane fade in active">
                                <h2>Gestion des commentaires</h2>
                                <table id="dtOrderExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="th-sm text-center ">Pseudo</th>
                                            <th class="th-sm text-center ">Contenu</th>
                                            <th class="th-sm text-center ">Date d'ajout</th>
                                            <th class="th-sm text-center ">Visibilité</th>
                                            <th class="th-sm text-center ">Validation</th>
                                            <th class="th-sm text-center ">Lien vers l'article</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($comments as $comment) {
                                            ?>
                                        <tr>
                                            <td><?= $comment->getAuthor()->getPseudo()?></td>
                                            <td><?= $comment->getContent() ?></td>
                                            <td><?= $comment->getCreationDate()->format('Y-m-d H:i')?></td>
                                            <td><i class="fa fa-eye<?= $comment->isValid()?"":"-slash";?>" aria-hidden="true"></i></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu" aria-labelledby="actionMenuButton">
                                                <?php
                                                if ($comment->isValid()) {
                                                    ?>
                                                        <a class="dropdown-item">
                                                            <form class="form-comment" action="/?action=invalidateComment&id=<?= $comment->getId() ?>"  method="post">
                                                                <input type="hidden" name="token" value="<?= $token ?>">
                                                                <button class="btn btn-warning btn-block" type="submit">Masquer</button>
                                                            </form>
                                                        </a>
                                                    <!-- <form class="form-comment" action="/?action=invalidateComment&id=<?= $comment->getId() ?>"     method="post">
                                                        <input type="hidden" name="token" value="<?= $token ?>">
                                                        <button class="btn btn-lg btn-warning btn-block" type="submit">Masquer</button>
                                                    </form> -->
                                                    <?php
                                                } else {
                                                    ?>
                                                        <a class="dropdown-item">
                                                            <form class="form-comment" action="/?action=validateComment&id=<?= $comment->getId() ?>"    method="post">
                                                                <input type="hidden" name="token" value="<?= $token ?>">
                                                                <button class="btn btn-success btn-block" type="submit">Valider</button>
                                                            </form>
                                                        </a>
                                                        <?php
                                                }
                                                ?>
                                                        <a class="dropdown-item">
                                                            <form class="form-comment" action="/?action=removeComment&id=<?= $comment->getId() ?>"    method="post">
                                                                <input type="hidden" name="token" value="<?= $token ?>">
                                                                <button class="btn btn-danger btn-block" type="submit">Supprimer</button>
                                                            </form>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="/?action=post&id=<?= $comment->getPostId()?>">Lien</a>
                                            </td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>








                                    <tfoot>
                                        <tr>
                                            <th>Pseudo</th>
                                            <th>Contenu</th>
                                            <th>Date d'ajout</th>
                                            <th>Visibilité</th>
                                            <th>Validation</th>
                                            <th>Lien vers l'article</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="usersManagement" class="tab-pane fade">
                                <h2>Gestion des utilisateurs</h2>
                                


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
ob_start();
?>
    <link href="Common/themes/css/datatables.min.css" rel="stylesheet">
<?php
$preBody=ob_get_clean();
ob_start();
?>
    <link href="Common/themes/css/datatables.min.css" rel="stylesheet">
    <script src="Common/themes/js/datatables.min.js"></script>
    <script type="text/javascript">
        $('#dtOrderExample').DataTable({"order": [[ 2, "desc" ]]});
        $('#dataTables_length').addClass('bs-select');
    </script>
<?php
$postBody=ob_get_clean();
?>
