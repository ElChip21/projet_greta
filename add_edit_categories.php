<?php
session_start();

require_once 'functions.php';

if (!empty($_POST)) {
    $description_categorie = $_POST['description_categorie'] ?? '';
    $nom_categorie = $_POST['nom_categorie'] ?? '';
    

    // Connection à la BDD avec la fonction connect() dans functions.php
    $db = connect();

    // Une catégorie n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  la catégorie a un ID.
    if (empty($_POST['id_categorie'])) {
         // S'il n'y a pas d'ID, la catégorie n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createCategorieStmt = $db->prepare('INSERT INTO categories (description_categorie, nom_categorie) VALUES (:description_categorie, :nom_categorie)');
            // Exécution de la requête
            $createCategorieStmt->execute(['description_categorie'=>$description_categorie, 'nom_categorie'=>$nom_categorie]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createCategorieStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Catégorie ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Catégorie non ajouté';
            }
        } catch (Exception $e) {
            // La catégorie n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'Catégorie non ajouté: ' . $e->getMessage();
        }
    } else {
        // La catégorie existe, on met à jour ses informations

        // Récupération de l'ID de la catégorie
        $id = filter_input(INPUT_POST, 'id_categorie', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations de la catégorie
        try {
            // Préparation de la requête de mis à jour
            $updateCategorieStmt = $db->prepare('UPDATE categories SET description_categorie=:description_categorie, nom_categorie=:nom_categorie  WHERE id_categorie=:id_categorie');
            // Exécution de la requête
           $updateCategorieStmt->execute(['description_categorie'=>$description_categorie, 'nom_categorie'=>$nom_categorie, 'id_categorie'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateCategorieStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Categorie mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Categorie non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Categorie non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $createCategorieStmt = null;
    $updateCategorieStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'categories.php?type=' . $type . '&message=' . $message);
}