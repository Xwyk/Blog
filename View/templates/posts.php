<div class="portfolio-modal" id="<?= $id ?>">
    <div class="modal-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2><?= $title ?></h2>
                        <hr class="star-primary">
                        <!-- <img src="<?= $imagePath ?>" class="img-responsive img-centered" alt=""> -->
                        <img src="../Common/themes/img/portfolio/cabin.png" class="img-responsive img-centered" alt="">
                        <p><?= $content ?></p>
                        <ul class="list-inline item-details">
                            <li>Auteur:
                                <strong><?= $author ?></strong>
                            </li>
                            <li>Date de création:
                                <strong><?= $creationDate ?></strong>
                            </li>
                            <li>Date de modification:
                                <strong><?= $modificationDate ?></strong>
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
                            <?=$comments?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>