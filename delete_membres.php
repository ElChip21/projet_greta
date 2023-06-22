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
        $deleteMembreStmt = $db->prepare('DELETE FROM membres WHERE id_membre=:id_membre');
        // Execution de la requête
        $deleteMembreStmt->execute(['id_membre' => $id]);
    
        $deleteAnnonceStmt = $db->prepare('DELETE FROM annonces WHERE id_annonce=:id_annonce');
        // Execution de la requête
        $deleteAnnonceStmt->execute(['id_annonce' => $id]);
    
        // Vérification qu'une ligne a été impactée avec rowCount()
        if ($deleteMembreStmt->rowCount()) {
            // La ligne a été détruite, on envoie un message de succès
            $type = 'success';
            $message = 'Membre supprimé';
        } else {
            // Aucune ligne n'a été impactée, on envoie un message d'erreur
            $type = 'error';
            $message = 'Membre non supprimé';
        }

    } catch (Exception $e) {
        // Une exception a été levée, on affiche le message d'erreur
        $type = 'error';
        $message = 'Exception message: ' . $e->getMessage();
    }
    // Fermeture de la connexion à la BDD
    $deleteMembreStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'Utilisateur.php?type=' . $type . '&message=' . $message);
} else {
    //Redirection vers l'Accueil s'il n'y a pas d'ID membre 
    header('location:'. 'index.php');
}