<?php

// Import des fonctions
require_once 'functions.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier un membre. Si l'url est appelée avec id= alors nous l'utiliserons pour éditer le membre avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id_membre = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations du membre depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $membreQuery pour récupérer les informations du membre
        $utilisateurQuery = $db->prepare('SELECT * FROM membres WHERE id_membre= :id_membre');
        // Exécuter la requête
        $utilisateurQuery->execute(['id_membre' => $id_membre]);
        // Récupérer les données et les assigner à $member
        $utilisateurs = $utilisateurQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $utilisateurQuery=null;
    $db=null;
}

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='Utilisateur.php' class='btn btn-secondary m-2 active' role='button'>Utilisateurs</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Utilisateur Form</h1>
</div>
<div class='row'>
    <form method='post' action='add_edit_utilisateur.php'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id_membre' value='<?= $utilisateurs['id_membre'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='nom'>Nom</label>
            <input type='text' name='nom' class='form-control' id='nom' placeholder="nom de l'utilisateur" required autofocus value='<?= isset($utilisateurs['nom']) ? htmlentities($utilisateurs['nom']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='prenom'>Prénom</label>
            <input type='text' name='prenom' class='form-control' id='prenom' placeholder='Prénom' required value='<?= isset($utilisateurs['prenom']) ? htmlentities($utilisateurs['prenom'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='username'>Nom d'utilisateur</label>
            <input type='text' name='username' class='form-control' id='username' placeholder="Nom d'utilisateur" required value='<?= isset($utilisateurs['username']) ? htmlentities($utilisateurs['username'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='num_telephone'>Numéro de téléphone</label>
            <input type='tel' name='num_telephone' class='form-control' id='num_telephone' placeholder='Numéro de téléphone' required value='<?= isset($utilisateurs['num_telephone']) ? htmlentities($utilisateurs['num_telephone'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='adresse_postale'>Adresse postale</label>
            <input type='text' name='adresse_postale' class='form-control' id='adresse_postale' placeholder='Adresse postale' required value='<?= isset($utilisateurs['adresse_postale']) ? htmlentities($utilisateurs['adresse_postale'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='code_postal'>Code postal</label>
            <input type='text' name='code_postal' class='form-control' id='code_postal' placeholder='Code postal' required value='<?= isset($utilisateurs['code_postal']) ? htmlentities($utilisateurs['code_postal'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='ville'>Ville</label>
            <input type='text' name='ville' class='form-control' id='ville' placeholder='Ville' required value='<?= isset($utilisateurs['ville']) ? htmlentities($utilisateurs['ville'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='email'>email</label>
            <input type='email' name='email' class='form-control' id='email' placeholder='email' required value='<?= isset($utilisateurs['email']) ? htmlentities($utilisateurs['email'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='pwd'>Mot de passe</label>
            <input type='password' name='pwd' class='form-control' id='pwd' placeholder='Mot de passe' required value='<?= isset($utilisateurs['pwd']) ? htmlentities($utilisateurs['pwd'])  : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='date_naissance'>Date de naissance</label>
            <input type='date' name='date_naissance' class='form-control' id='date_naissance' placeholder='Date de naissance' required value='<?= isset($utilisateurs['date_naissance']) ? htmlentities($utilisateurs['date_naissance'])  : '' ?>'>
        </div>
            </select>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>