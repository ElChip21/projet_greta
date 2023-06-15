<?php
//VERSION ORIENTER OBJET!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
require_once 'functions.php';

// L'ID est-il dans les paramètres d'URL?
if (isset($_GET['id'])) {

    // Récupérer $id depuis l'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $db = connect();
    try {
        // Préparation de la requête de mis à jour
        $valideAnnonceStmt = $db->prepare('UPDATE annonces SET  actif = 1 WHERE id_annonce=:id_annonce');
        // Exécution de la requête
       $valideAnnonceStmt->execute(['id_annonce'=>$id]);
        // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
        if ($valideAnnonceStmt->rowCount()) {
            // Une ligne a été mise à jour => message de succès
            $type = 'success';
            $message = "L'annonce à été activée";
        } else {
            // Aucune ligne n'a été mise à jour => message d'erreur
            $type = 'error';
            $message = 'Annonce non active';
        }
    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    $valideAnnonceStmt = null;
    $db = null;

    // Redirection vers la page principale des annonces en passant le message et son type en variables GET
    header('location:' . 'Annonces.php?type=' . $type . '&message=' . $message);
} else {
    //Redirection vers l'Accueil s'il n'y a pas d'ID annonce 
    header('location:'. 'index.php');
}










