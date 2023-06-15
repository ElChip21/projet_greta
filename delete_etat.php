<?php
require_once 'functions.php';

// L'ID est-il dans les paramètres d'URL?
if (isset($_GET['id'])) {

    // Récupérer $id depuis l'URL
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Connection à la BDD avec la fonction connect() dans functions.php
        $db = connect();

        // Préparation de la requête pour supprimer la catégorie correspondant à l'id
        $deleteEtatStmt = $db->prepare('DELETE FROM etats WHERE id_etat=:id_etat');
        // Execution de la requête
        $deleteEtatStmt->execute(['id_etat' => $id]);
    
        // Vérification qu'une ligne a été impactée avec rowCount()
        if ($deleteEtatStmt->rowCount()) {
            // La ligne a été détruite, on envoie un message de succès
            $type = 'success';
            $message = 'Etat supprimé';
        } else {
            // Aucune ligne n'a été impactée, on envoie un message d'erreur
            $type = 'error';
            $message = 'Etat non supprimé';
        }

    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    $deleteEtatStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'etat.php?type=' . $type . '&message=' . $message);
} else {
    //Redirection vers l'Accueil s'il n'y a pas d'ID membre 
    header('location:'. 'index.php');
}