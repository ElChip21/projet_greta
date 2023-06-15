<?php
session_start();
// Import des fonctions
require_once 'functions.php';

// Pour éviter de dupliquer le code, ce formulaire sera utiliser pour créer ou modifier un membre. Si l'url est appelée avec id= alors nous l'utiliserons pour éditer le membre avec l'id spécifié. 
if (isset($_GET['id'])) {
    // récupérer $id dans les paramètres d'URL
    $id_etat = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Charger les informations du membre depuis la BDD pour remplir le formulaire
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer $categorieQuery pour récupérer les informations du membre
        $etatQuery = $db->prepare('SELECT * FROM etats WHERE id_etat= :id_etat');
        // Exécuter la requête
        $etatQuery->execute(['id_etat' => $id_etat]);
        // Récupérer les données et les assigner à $member
        $etats = $etatQuery->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
    // Fermer la connection à la BDD
    $etatQuery=null;
    $db=null;
}

?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='etat.php' class='btn btn-secondary m-2 active' role='button'>Etats</a>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark bg-primary text-white'>Etats Form</h1>
</div>
<div class='row'>
    <form method='post' action='add_edit_etat.php'>
        <!--  Ajouter the ID to the form if it exists but make the field hidden -->
        <input type='hidden' name='id_etat' value='<?= $etats['id_etat'] ?? '' ?>'>
        <div class='form-group my-3'>
            <label for='libelle_etat'>Etats</label>
            <input type='text' name='libelle_etat' class='form-control' id='libelle_etat' placeholder="nom de l'état" required autofocus value='<?= isset($etats['libelle_etat']) ? htmlentities($etats['libelle_etat']) : '' ?>'>
        </div>
        <div class='form-group my-3'>
            <label for='description_etat'>Description de l'état</label>
            <input type='text' name='description_etat' class='form-control' id='description_etat' placeholder="Description de l'état" required value='<?= isset($etats['description_etat']) ? htmlentities($etats['description_etat'])  : '' ?>'>
        </div>
            </select>
        </div>
        <button type='submit' class='btn btn-primary my-3' name='submit'>Submit</button>
    </form>
</div>