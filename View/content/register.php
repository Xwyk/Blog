<div class="portfolio-modal" >
	<div class="modal-content">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-4 col-lg-offset-4">
	            	<form class="form-signin" action="/?action=register" method="post">
    					<h1 class="h3 mb-3 font-weight-normal">Inscription</h1>
    					<p class="text-danger"><?= $error ?? ""?></p>
    					<label for="inputFirstName" class="sr-only">Prénom</label>
						<input type="name" id="inputFirstName" class="form-control" placeholder="Prénom" required="" autofocus="" name="firstName">
    					<label for="inputLastName" class="sr-only">Nom</label>
						<input type="name" id="inputLastName" class="form-control" placeholder="Nom" required="" autofocus="" name="lastName">
						<label for="inputPseudo" class="sr-only">Pseudo</label>
						<input type="name" id="inputPseudo" class="form-control" placeholder="Pseudo" required="" autofocus="" name="pseudo">
						<label for="inputEmail" class="sr-only">Adresse mail</label>
						<input type="email" id="inputEmail" class="form-control" placeholder="Adresse mail" required="" autofocus="" name="email">
						<label for="inputPassword" class="sr-only">Mot de passe</label>
						<input type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" required="" name="password">
						<div class="checkbox mb-3">
						<label>
							<!-- <input type="checkbox" value="remember-me"> Remember me -->
						</label>
						</div>
						<button class="btn btn-lg btn-primary btn-block" type="submit">S'inscrire</button>
						<p>Déjà membre ? <a href="/?action=login">Se connecter</a></p>
				    </form>
	            </div>
	        </div>
	    </div>
	</div>
</div>