<?php
session_start();

require_once 'functions.php';

if (!empty($_POST)) {
    $description_etat = $_POST['description_etat'] ?? '';
    $libelle_etat = $_POST['libelle_etat'] ?? '';
    

    // Connection à la BDD avec la fonction connect() dans functions.php
    $db = connect();

    // Une catégorie n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  la catégorie a un ID.
    if (empty($_POST['id_etat'])) {
         // S'il n'y a pas d'ID, la catégorie n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createEtatStmt = $db->prepare('INSERT INTO etats (description_etat, libelle_etat) VALUES (:description_etat, :libelle_etat)');
            // Exécution de la requête
            $createEtatStmt->execute(['description_etat'=>$description_etat, 'libelle_etat'=>$libelle_etat]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createEtatStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Etat ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Etat non ajouté';
            }
        } catch (Exception $e) {
            // La catégorie n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'Etat non ajouté: ' . $e->getMessage();
        }
    } else {
        // La catégorie existe, on met à jour ses informations

        // Récupération de l'ID de la catégorie
        $id = filter_input(INPUT_POST, 'id_etat', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations de la catégorie
        try {
            // Préparation de la requête de mis à jour
            $updateEtatStmt = $db->prepare('UPDATE etats SET description_etat=:description_etat, libelle_etat=:libelle_etat  WHERE id_etat=:id_etat');
            // Exécution de la requête
           $updateEtatStmt->execute(['description_etat'=>$description_etat, 'libelle_etat'=>$libelle_etat, 'id_etat'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateEtatStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Etat mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Etat non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Etat non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $createEtatStmt = null;
    $updateEtatStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'etat.php?type=' . $type . '&message=' . $message);
}