


<!-- Portfolio Grid Section -->
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Portfolio</h2>
                <hr class="star-primary">
            </div>
        </div>
        <div class="row">
            <?php 
            	foreach ($articles as $key => $article) {
            ?>
            		<div class="col-sm-4 portfolio-item">
						<a href='/?action=post&id=<?= $article->getId() ?>' class="portfolio-link" data-toggle="modal">
						    <div class="caption">
						        <div class="caption-content">
						            <i class="fa fa-search-plus fa-3x"></i>
						        </div>
						    </div>
						    <!-- <img src="<?= $imagePath ?>" class="img-responsive" alt=""> -->
						    <img src="../Common/themes/img/portfolio/cabin.png" class="img-responsive" alt="">
						    <p><?= $article->getChapo() ?></p>
						</a>
					</div>
            <?php
            	}
            ?>
        </div>
    </div>
</section>