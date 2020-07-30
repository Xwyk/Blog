<div class="portfolio-modal" >
    <div class="modal-content">
        <div class="container">
        	<h1>Interface d'administration</h1>
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#commentsManagement">Gestion des commentaires</a></li>
				<li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
				<li><a href="/?action=addPost">Ajouter un article</a></li>
			</ul>
	
			<div class="tab-content">
				<div id="commentsManagement" class="tab-pane fade in active">
					<h3>Gestion des commentaires</h3>
					<div class="row">
        	        	<div class="col-lg-8 col-lg-offset-2">
        	        	    <div class="modal-body">
							<?php
								foreach ($invalidComments as $comment) {
							?>
				    	        <div class="row">
				    	            <div class="col-sm-3 text-left">
				    	                <h5><a href="/?action=user&id=<?= $comment->getAuthor()->getId() ?>"><b><?= $comment->getAuthor()->getPseudo()?></b></a></h5>
				    	                <h6 class="text-muted time"><?= $comment->getCreationDate()->format('Y-m-d H:i')?></h6>
				    	            </div>
				    	            <div class="col-sm-7 text-justify"> 
				    	                <p><?= $comment->getContent() ?></p>
				    	            </div>
				    	            <div class="col-sm-2 text-right"> 
				    	                <form class="form-comment" action="/?action=validateComment&id=<?= $comment->getId() ?>" method="post">
				    	                    <button class="btn btn-lg btn-success btn-block" type="submit">Valider</button>
				    	                </form>
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
				<div id="menu1" class="tab-pane fade">
					<h2>Menu 1</h2>
					<p>Some content in menu 1.</p>
				</div>
			</div>
		</div>
	</div>
</div>