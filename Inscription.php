<?php
require_once("functions.php");
connect();
?>


<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Inscription</title>
</head>
<body>
<h1>Inscription</h1>
<form method="POST">
    <p><label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom"></p>
    <br>
    <p><label for="prenom">prenom:</label>
        <input type="text" name="prenom" id="prenom"></p>
       
        <br>
    <p><label for="username">Nom d'utilisateur:</label>
        <input type="text" name="username" id="username" required></p>
        <br>
    <p><label for="tel">Téléphone:</label>
        <input type="tel" name="tel" id="tel" required></p>
        <br>
    <p><label for="email">Email:</label>
        <input type="email" name="mail" id="mail" required></p>
        <br>
    <p><label for="mdp">Mot de passe(8 caractère au minimum):</label>
        <input type="password" name="password" id="password" minlength="8" required>
        <br>
    <p><label for="adresse">Adresse:</label>
        <input type="texte" name="adresse" id="adresse"></p>
        <br>
    <p><label for="code_postal">Code postal</label>
    <input type="number" name="code_postal" id="code_postal"></p>
    <br>
    <input type="submit" value="Valider l'inscription">



<?php


/*$nom= $_POST["nom"];
$prenom = $_POST["prenom"];
$mail = $_POST["email"];
$tel = $_POST["tel"];
$username=$_POST["username"];
$mdp= $_POST["mdp"];
$adresse= $_POST["adresse"];
$code_postal= $_POST["code_postal"];*/