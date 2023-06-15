<div class="main">  	
	<input type="checkbox" id="chk" aria-hidden="true">
	<div class="signup">
		<form method="POST" action="">
			<label for="chk" aria-hidden="true">Enregistrement</label>
			<input type="hidden" name="action" value="signup">
			<input type="text" name="nom" placeholder="Nom" required="">
			<input type="email" name="email" placeholder="Email" required="">
			<input type="password" name="pwd" placeholder="Mot de passe" required="" pattern="^(?=.*\d)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}$" title="Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial">
			<input type="password" name="pwd2" placeholder="Confirmation du mot de passe" required="">
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