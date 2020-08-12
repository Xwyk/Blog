<div class="portfolio-modal" >
    <div class="modal-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="modal-body">
                         <form class="form-comment" action="/?action=editPost&id=<?=$post->getId()?>" method="post" enctype="multipart/form-data">
                            <label for="postTitle" class="text-left">Titre de l'article</label>
                            <input type="text" class="form-control" placeholder="Titre de l'article" required="" name="postTitle" value="<?=$post->getTitle()?>"></input>
                            <label for="postChapo" class="text-left">Chapo</label>
                            <input type="text" class="form-control" placeholder="Chapo" required="" name="postChapo" value="<?=$post->getChapo()?>"></input>
                            <label for="postImage" class="text-left">Image</label>
                            <input type="file" name="postImage">
                            <label for="postContent" class="text-left">Contenu de l'article</label>
                            <textarea style="resize: none;" class="form-control" placeholder="Texte de l'article" required="" name="postContent"><?=$post->getContent()?></textarea>
                            <input type="hidden" name="validate" value="1"></input>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Sauvegarder</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>