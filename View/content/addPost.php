<!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'textarea'});</script> -->
<?php $mainTitle = "Ajout d'un article"?>
<div class="portfolio-modal" >
    <div class="modal-content">
		<h1><?= $mainTitle ?? "Titre par défaut" ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
						<form class="form-comment" action="/?action=addPost" method="post">
							<label for="postTitle" class="sr-only">Titre de l'article</label>
						    <input type="text" class="form-control" placeholder="Titre de l'article" required="" name="postTitle"></input>
						    <label for="postChapo" class="sr-only">Chapo</label>
						    <input type="text" class="form-control" placeholder="Chapo" required="" name="postChapo"></input>
						    <label for="postContent" class="sr-only">Contenu de l'article</label>
						    <textarea style="resize: none;" class="form-control" placeholder="Texte de l'article" required="" name="postContent"></textarea>
						    <input type="hidden" name="validate" value="1"></input>
						    <button class="btn btn-lg btn-primary btn-block" type="submit">Sauvegarder</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>