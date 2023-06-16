
<div class="main">  	
	<div class="home">
		<?php if (!$logged):?>
		<a class="button" href="?p=signup">Créer un compte</a>
		<a class="button" href="?p=signup">Se connecter</a>
		<?php else:;?>
		
		<a class="button" href="?p=deconnect">Se déconnecter</a>
		<a class="button" href="../../index.php">Accueil</a>
		<?php endif;?>
	</div>
</div>