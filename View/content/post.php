<div class="portfolio-modal" >
    <div class="modal-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2><?= htmlspecialchars(strtoupper($post->getTitle())) ?></h2>
                        <hr class="star-primary">
                        <!-- <img src="<?= $imagePath ?>" class="img-responsive img-centered" alt=""> -->
                        <img src="<?=htmlspecialchars($post->getPicture()) ?? '/Common/themes/img/portfolio/cabin.png'?>" class="img-responsive img-centered" alt="">
                        <p><?= htmlspecialchars(nl2br($post->getContent())) ?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= htmlspecialchars($post->getAuthor()->getFirstName()).' '.htmlspecialchars($post->getAuthor()->getLastName()).' ('.htmlspecialchars($post->getAuthor()->getPseudo()).')' ?></strong>
                            </li>
                            <li>Date de création:
                                <strong><?= htmlspecialchars($post->getCreationDate()->format('Y-m-d H:i')) ?></strong>
                            </li>
                            <li>Date de modification:
                                <strong><?= htmlspecialchars($post->getModificationDate()->format('Y-m-d H:i')) ?></strong>
                            </li>
                            <li>Service:
                                <strong><a href="http://startbootstrap.com">Web Development</a>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <div class="container-fluid">
<?php
foreach ($post->getComments() as $comment) {
    ?>
                            <div class="row">
                                <div class="col-lg-2 text-left">
                                    <img src="http://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar " alt="user profile image">
                                </div>
                                <div class="col-lg-3 text-left">
                                    <h5><a href="/?action=user&id=<?= htmlspecialchars($comment->getAuthor()->getId()) ?>"><b><?= htmlspecialchars($comment->getAuthor()->getPseudo())?></b></a></h5>
                                    <h6 class="text-muted time"><?= htmlspecialchars($comment->getCreationDate()->format('Y-m-d H:i'))?></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-justify"> 
                                    <p><?= htmlspecialchars($comment->getContent()) ?></p>
                                </div>
                            </div>
                            <hr>

    <?php
}
if ($session->existAttribute("user")) {
    if ($session->getAttribute("user")->getType()>0) {
        ?>
                            <form class="form-comment" action="/?action=addComment&postId=<?= htmlspecialchars($post->getId()) ?>" method="post">
                                <label for="commentText" class="sr-only">Mot de passe</label>
                                <textarea style="resize: none;" class="form-control" placeholder="Ajouter un commentaire" required="" name="commentText"></textarea>
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter un commentaire</button>
                            </form>
        <?php
    }
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
