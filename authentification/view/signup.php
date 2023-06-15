<div>  	 <!--class="main"-->
	<input type="checkbox" id="chk" aria-hidden="true">
	<div > <!--class="signup"-->
		<form method="POST" action="">
			<label for="chk" aria-hidden="true">Enregistrement</label>
			<input type="hidden" name="action" value="signup">
			<input type="text" name="nom" placeholder="Nom" required="">
			<input type="text" name="prenom" placeholder="Prénom" required="">
			<input type="text" name="username" placeholder="Nom d'utilisateur" required="">
			<input type="number" name="num_telephone" placeholder="Numéro de téléphone">
			<input type="text" name="adresse_postale" placeholder="Adresse">
			<input type="text" name="ville" placeholder="Ville" required="">
			<input type="text" name="code_postal" placeholder="Code postal" required="">
			
			<label for="date_naissance">Date de naissance</label>
			<input type="date" name="date_naissance" placeholder="Date de naissance" required="">
			<input type="email" name="email" placeholder="Email" required="">
			
			<input type="password" name="pwd" placeholder="Mot de passe" required="" pattern="^(?=.*\d)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}$" title="Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial">
			<input type="password" name="pwd2" placeholder="Confirmation du mot de passe" required="">
			<input type="file" name="avatar[]" accept="image/*" multiple>
			<button>Enregistrement</button>
		</form>
	</div>

	<div class="login" action="">
		<form method="POST">

			<label for="chk" aria-hidden="true">Login</label>
			<input type="hidden" name="action" value="login">
			<input type="email" name="email" placeholder="Email" required="">
			<input type="password" name="pwd" placeholder="Mot de passe" required="">
			<button>Login</button>
			<a href="?p=forgot">Mot de passe oublié ?</a>
		</form>
	</div>
</div>