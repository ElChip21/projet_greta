<?php

// Import des fonctions
require_once 'functions.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier un membre. Si l'url est appelée avec id= alors nous l'utiliserons pour éditer le membre avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id_categorie = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations du membre depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $categorieQuery pour récupérer les informations du membre
        $categorieQuery = $db->prepare('SELECT * FROM categories WHERE id_categorie= :id_categorie');
        // Exécuter la requête
        $categorieQuery->execute(['id_categorie' => $id_categorie]);
        // Récupérer les données et les assigner à $member
        $categories = $categorieQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $categorieQuery=null;
    $db=null;
}

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='categories.php' class='btn btn-secondary m-2 active' role='button'>Catégories</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Categories Form</h1>
</div>
<div class='row'>
    <form method='post' action='add_edit_categories.php'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id_categorie' value='<?= $categories['id_categorie'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='nom_categorie'>Nom de la catégorie</label>
            <input type='text' name='nom_categorie' class='form-control' id='nom_categorie' placeholder='nom de la catégorie' required autofocus value='<?= isset($categories['nom_categorie']) ? htmlentities($categories['nom_categorie']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='description_categorie'>Description de la catégorie</label>
            <input type='text' name='description_categorie' class='form-control' id='description_categorie' placeholder='Description de la catégorie' required value='<?= isset($categories['description_categorie']) ? htmlentities($categories['description_categorie'])  : '' ?>'>
        </div>
            </select>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>