<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Contact</title>
</head>
<body>
<h1>Contact</h1>
<p>Une suggestion? Une demande? Un problème? N'hésitez pas à nous écrire!</p>
<br>
<form method="POST">
   
    <p><label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required></p>
    <br>
    <p><label for="email">Email</label>
        <input type="email" name="email" id="email" required></p>
    <br>
    <p><label for="message">Veuillez saisir votre message:</label>
        <input type="textarea" name="message" id="message" required></p>
    <input type="submit" value="Envoyer">

<?php
/*
$serveur = "localhost";
$dbname = "mydb";
$user = "root";
$password = "";


$nom= $_POST["nom"];
$prenom = $_POST["prenom"];
$mail = $_POST["email"];
$tel = $_POST["tel"];
$username=$_POST["username"];
$mess= $_POST["mess"];


try{
    //On se connecte à la BDD
    $dbco = new PDO("mysql:host=$serveur;dbname=$dbname",$user,$password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //On insère les données reçues si les champs sont remplis
    if(!empty($prenom) && !empty($mail) && !empty($nom) && !empty($tel) && !empty($username) && !empty($mess)){
        $sth = $dbco->prepare("
            INSERT INTO membres(prenom,nom,tel,username,mess,mail)
            VALUES(:prenom, :nom, :tel, :username, :mess, :mail)");
        $sth->bindParam(':prenom',$prenom);
        $sth->bindParam(':mail',$mail);
        $sth->bindParam(':nom',$nom);
        $sth->bindParam(':nom',$tel);
        $sth->bindParam(':nom',$username);
        $sth->bindParam(':nom',$mess);
        $sth->execute();
    }
    
    //On récupère les infos de la table 
    $sth = $dbco->prepare("SELECT prenom, mail, nom, tel, username, mess,   FROM form");
    $sth->execute();
    //On affiche les infos de la table
    $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);
    $keys = array_keys($resultat);
    for($i = 0; $i < count($resultat); $i++){
        $n = $i + 1;
        echo 'Utilisateur n°' .$n. ' :<br>';
        foreach($resultat[$keys[$i]] as $key => $value){
            echo $key. ' : ' .$value. '<br>';
        }
        echo '<br>';
    }
}   
catch(PDOException $e){
    echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
}
*/