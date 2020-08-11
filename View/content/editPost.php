<div class="portfolio-modal" >
    <div class="modal-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                        <h2><?= htmlspecialchars(strtoupper($post->getTitle())) ?></h2>
                        <hr class="star-primary">
                        <img src="/Common/themes/img/portfolio/cabin.png" class="img-responsive img-centered" alt="">
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
        </div>
    </div>
</div>