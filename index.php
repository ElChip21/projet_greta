<?php
session_start();
?>

<!-- déclaration aux navigateurs d'une page html5 -->
<!DOCTYPE html>
<!-- déclaratioon de la langue française -->
<html lang="fr">
<head>
<!-- déclaration d'utilisation des caractères utf8-->
<meta charset="utf-8" />
<!-- déclaration du fichier css à charger -->
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="style.css" />
<title>Mes petites annonces</title>
</head>
<body>
<div id="top"> 
<ul>
	<li><a href="/">Accueil</a></li>
	<li><a href="javascript:history.go(-1)">Retour</a></li>
</ul>
<h1>Mes petites annonces</h1>
</div>
<div id="bar">
<!-- formulaire de recherche par mot clé -->
<form action="search.php" method="post">
Recherche par mots clés:
<input type="text" name="recherche" />
<br />
<label for="mots">Tous les mots</label>
	<input type="radio" name="mode" value="tous_les_mots" id="mots">
<label for="mot">Au moins un mot</label>
	<input type="radio" name="mode" value="un_mot" checked="checked" id="mot">
	<input type="submit" value="Rechercher" name="rechercher" />
</form>
</div>
<div id="main">
<div id="column_left">
<h2>Catégories</h2>
<ul>
<li><a> Véhicule </a></li>
<li><a> Immobilier </a></li>
<li><a> Emploi </a></li>
<li><a> Rencontre </a></li>
<li><a> Mode </a></li>
<li><a> Objets </a></li>
<li><a> Animaux </a></li>
</ul>
</div>
<div id="column_right">
<ul>


			
			
		
		<?php var_dump($_SESSION);
		if(isset($_SESSION['id_membre'])){?>
			<ul>
			<li><a class="button" href="authentification/index_authentification.php/?p=deconnect">Se déconnecter</a></li>
			</ul> <?php
			echo "Bonjour ".$_SESSION['username']."!";
		}else{
		?>
		
        <ul>
            <li><a href="authentification/index_authentification.php">Je m'identifie</a></li>
            <li><a href="authentification/index_authentification.php">Je crée un compte</a> (nécessaire pour déposer une annonce)</li>
            <li><a href="authentification/index_authentification.php">J'ai oublié mes identifiants</a></li>
        </ul><?php } ?>
		<br><br>
			<ul>
				<li><a href="annonces_form.php">Ajouter une annonce</a></li>
				<?php if($_SESSION['is_admin']== true){  ?><li><a href="Utilisateur.php">Panneau d'administration (gérer les membres)</a></li>
																<li><a href="etat.php">Modifier/Ajouter un/des état(s) d'annonce(s)</a></li>
					<?php }else{  ?>
					<li><a href="Utilisateur.php">Modifier ses informations </a></li><?php } ?>
<div class="spacer"></div>
</div>
<div id="footer">
    <a href="condition.php">Conditions d'utilisation</a> | <a href="propos.php">À propos de ce site</a> | <a href="Contact.php">Nous contacter</a>
</div>
</body>
</html>