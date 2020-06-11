<div class="portfolio-modal" >
    <div class="modal-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2><?= $post->getTitle() ?></h2>
                        <hr class="star-primary">
                        <!-- <img src="<?= $imagePath ?>" class="img-responsive img-centered" alt=""> -->
                        <img src="/Common/themes/img/portfolio/cabin.png" class="img-responsive img-centered" alt="">
                        <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= $post->getAuthor()->getFirstName().' '.$post->getAuthor()->getLastName().' ('.$post->getAuthor()->getPseudo().')' ?></strong>
                            </li>
                            <li>Date de création:
                                <strong><?= $post->getCreationDate()->format('Y-m-d H:i') ?></strong>
                            </li>
                            <li>Date de modification:
                                <strong><?= $post->getModificationDate()->format('Y-m-d H:i') ?></strong>
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
                                        <h5><a href="/?action=user&id=<?= $comment->getAuthor()->getId() ?>"><b><?= $comment->getAuthor()->getPseudo()?></b></a></h5>
                                        <h6 class="text-muted time"><?= $comment->getCreationDate()->format('Y-m-d H:i')?></h6>
                                    </div>
                                    <div class="col-lg-7 text-justify"> 
                                        <p><?= $comment->getContent() ?></p>
                                    </div>
                                </div>
                                <hr>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>