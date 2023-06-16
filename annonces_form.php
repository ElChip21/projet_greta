<?php
session_start();
// Import des fonctions
require_once 'functions.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier une annonce. Si l'url est appelée avec id_annonce= alors nous l'utiliserons pour éditer l'annonce avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id_annonce = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations du membre depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $annonceQuery pour récupérer les informations de l'annonce
        $annonceQuery = $db->prepare('SELECT * FROM annonces WHERE id_annonce= :id_annonce');
        // Exécuter la requête
        $annonceQuery->execute(['id_annonce' => $id_annonce]);
        // Récupérer les données et les assigner à $member
        $annonce = $annonceQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $annonceQuery=null;
    $db=null;
    
}

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='Annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonce</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Annonce Form</h1>
</div>
<div class='row'>
    <form method='post' action='add_edit_annonces.php'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id_annonce' value='<?= $annonce['id_annonce'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='titre'>Nom de l'annonce</label>
            <input type='text' name='titre' class='form-control' id='titre' placeholder="nom de l'annonce" required autofocus value='<?= isset($annonce['titre']) ? htmlentities($annonce['titre']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='description_annonces'>Description de l'annonce</label>
            <textarea name='description_annonces' class='form-control' id='description_annonces' placeholder="Description de l'annonce" required ><?= isset($annonce['description_annonces']) ? htmlentities($annonce['description_annonces'])  : '' ?></textarea>
        </div>
        <div class='form-group my-3'>
            <label for='prix_vente'>Prix de la vente</label>
            <input type='text' name='prix_vente' class='form-control' id='prix_vente' placeholder="Prix de la vente" required value='<?= isset($annonce['prix_vente']) ? htmlentities($annonce['prix_vente'])  : '' ?>'>
        </div>
            </select>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>